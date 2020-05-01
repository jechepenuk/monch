<?php
$message="";

include_once "access-db.php";
$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);
$following=explode(",", $myinfo['following']);  
$postsresults = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");


if (isset($_POST['like'])){
    $postid=$_POST['postid'];
    $likedThings=$myinfo['likedposts'];
    $post = mysqli_query($conn,"SELECT * FROM posts WHERE id='" . $postid . "'");
    $postinfo=mysqli_fetch_array($post);
    $liked=explode(",", $likedThings);
    $counts = array_count_values($liked);
    $likes=$postinfo['likes'];
    $count=$counts[$postid];
    if (!in_array($postid, $liked) || $count % 2 == 0){
        $likes=$likes+1;
    }else{
        $likes=$likes-1;    
    }
    $updateLikes=$likedThings . $postid . ",";
    mysqli_query($conn,"UPDATE users SET likedposts='" . $updateLikes . "' WHERE user_id='" . $_GET['user_id'] . "'"); 
    mysqli_query($conn,"UPDATE posts SET likes='" . $likes . "' WHERE id='" . $postid . "'"); 
    $URL="http://localhost:8000/feed.php?user_id=".$_GET['user_id']; 
    echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}

if (isset($_POST['addcomment'])){
    $postid=$_POST['postid'];
    $commenter=$_GET['user_id'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $commenter . "'");
    $row2 = mysqli_fetch_array($result2);
    $commenter=$row2['username'];
    $comment=$_POST['comment'];
    $post = mysqli_query($conn,"SELECT * FROM posts WHERE id='" . $postid . "'");
    $postinfo=mysqli_fetch_array($post);
    $currComments=$postinfo['comments'];
    $updatedComments=$currComments . ',' . $commenter . ': ' . $comment;
    mysqli_query($conn,"UPDATE posts SET comments='" . $updatedComments . "' WHERE id='" . $postid . "'"); 
    $URL="http://localhost:8000/feed.php?user_id=".$_GET['user_id']; 
    echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}


if (isset($_POST['search'])){
    $username=$_POST['search'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $username . "'");
    if (mysqli_num_rows($result2)<1){
        $URL="http://localhost:8000/user-not-found.php?user_id=".$_GET['user_id']; 
        echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
    }else{
        $user=mysqli_fetch_array($result2);
        if ($user['user_id']==$_GET['user_id']){
            $URL="http://localhost:8000/profile.php?user_id=".$_GET['user_id']; 
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
        }else{
            $URL="http://localhost:8000/friend-profile.php?user_id=".$_GET['user_id'].'&friend='.$user['user_id']; 
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
    <title>CF</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    
    <div class="innerwrapper">
    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.php')">login</a> </li> -->
                <li><a class="navlink" href="./messages.php?user_id=<?php echo $_GET['user_id'];?>">messages</a> </li>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id'];?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a></li>
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.php">Community Foods</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
    } ?> 
    </div> 
    <h1 class="welcome-page-title">Welcome back, <?php echo $myinfo['username'];?>.</h1>

    <button class="selectButtonNarrow" onclick="window.location.href = './upload.php?user_id=<?php echo $_GET['user_id']; ?>'">add post</button><br><br>
    <hr class='navbar'><br><br>

    <?php while ($singlePost=mysqli_fetch_array($postsresults)){ 
    if (in_array($singlePost['user_id'], $following) || $singlePost['user_id']==$_GET['user_id'] ){
        if ($singlePost['user_id']==$_GET['user_id']){
            $link="./profile.php?user_id=" . $_GET['user_id'];
        }else{
            $link="./friend-profile.php?user_id=".$_GET['user_id']. "&friend=" . $singlePost['user_id'];
        }
        $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $singlePost['user_id'] . "'");
        $user = mysqli_fetch_array($result2);
        $linkname=$user['username'];
        $comments=$singlePost['comments'];
        $commArray=explode(",", $comments);  
        if ($user['user_image']){
            echo '<img class="smallPic" src="data:image/jpeg;base64,'. $user['user_image'] .'"/>';
        }else{
            echo '<img class="smallPic" src="public/user-default.jpg" alt="you"';
        }
        echo "<br>";

        echo "<a class='proflink' href=".$link.">$linkname</a>";
        if ($singlePost['caption']){
            echo "<a class='center'>\"".$singlePost['caption']."\"</a>";
        }
        echo "<br>";
        echo '<img class="feedPic" src="'. $singlePost['image'].'"alt="you"><br>'; 
        echo '<form class="center" method="post" action="">
            <input class="addcomment" type="text" id="comment" name="comment" placeholder="say something...">  
            <input type="hidden" name="postid" value='.$singlePost['id'].'>
            <input type="submit" name="addcomment" value="add">
            </form><br>';
        echo '<form method="post" action=""><input type="hidden" name="postid" value='.$singlePost['id'].'>
            <input type="submit" name="like" class="rate" value="&hearts; '.$singlePost['likes'].'"></form>';    
        for($i=0; $i<count($commArray); $i++){
            echo '<p class="center">'.$commArray[$i].'</p><br>';
        }
        echo "<hr class='navbar'><br><br>";
        }
    }
    ?>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


</body>

