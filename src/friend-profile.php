<?php
$message="";

include_once "access-db.php";
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row = mysqli_fetch_array($result);
$result2 = mysqli_query($conn,"SELECT * FROM posts WHERE user_id='" . $_GET['friend'] . "' ORDER BY id DESC ");

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
    header('Refresh: 0');
}
if (isset($_POST['follow'])){
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
    $row2 = mysqli_fetch_array($result2);
    $following=$row2['following'];
    $updatedFollow=$following . ','.$_GET['friend'];
    mysqli_query($conn,"UPDATE users SET following='" . $updatedFollow . "' WHERE user_id='" . $_GET['user_id'] . "'"); 
    header('Refresh: 0');
}
if (isset($_POST['unfollow'])){
    $user=$_GET['user_id'];
    $friend=$_GET['friend'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $user . "'");
    $row = mysqli_fetch_array($result2);

    $currfollow=$row['following'];
    $currfollow=\array_diff($friend,$currfollow);  
    mysqli_query($conn,"UPDATE users SET following='" . $currfollow . "' WHERE user_id='" . $user . "'"); 
    header('Refresh: 0');
}
if (isset($_POST['message'])){
    header('Location: ./chat.php?user_id=' . $_GET['user_id'] . '&friend=' . $_GET['friend']);
}
if (isset($_POST['search'])){
    $username=$_POST['search'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $username . "'");
    if (mysqli_num_rows($result2)<1){
        header('Location: ./user-not-found.php?user_id='.$_GET['user_id']);
    }else{
        $user=mysqli_fetch_array($result2);
        header('Location: ./friend-profile.php?user_id='.$_GET['user_id'].'&friend='.$user['user_id']);
    }

}
if (isset($_POST['like'])){
    $postid=$_POST['postid'];
    $likedThings=$myinfo['likedposts'];
    $post = mysqli_query($conn,"SELECT * FROM posts WHERE id='" . $postid . "'");
    $postinfo=mysqli_fetch_array($post);
    $liked=explode(",", $likedThings);
    if (!in_array($postid,$liked)){
        $likes=$postinfo['likes'];
        $likes=$likes+1;
        $updateLikes=$likedThings . $postid;
        mysqli_query($conn,"UPDATE users SET likedposts='" . $updateLikes . "' WHERE user_id='" . $_GET['user_id'] . "'"); 
        mysqli_query($conn,"UPDATE posts SET likes='" . $likes . "' WHERE id='" . $postid . "'"); 
        header('Refresh: 0');
    }else{
        $liked=\array_diff($postid,$liked);
        $updateLikes=implode(",",$liked);
        $likes=$postinfo['likes'];
        $likes=$likes-1;
        mysqli_query($conn,"UPDATE posts SET likes='" . $likes . "' WHERE id='" . $postid . "'"); 
        mysqli_query($conn,"UPDATE users SET likedposts='" . $updateLikes . "' WHERE user_id='" . $_GET['user_id'] . "'"); 
        header('Refresh: 0');

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
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="main-container">

    <div class="header">
        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.html')">login</a> </li> -->

                <li><a class="navlink" href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">feed</a> </li>    
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id'];?>">profile</a> </li>         
                <li><a class="navlink" href="../index.php">logout</a> </li>
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>


            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.php">Community Foods</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
        
        } ?> 
    </div> 
    <h1 class="welcome-page-title"><?php echo $row['username'];?></h1>

    <br><br>
    <?php
    if ($row['user_image']){
     echo '<img class="profilePicture" src="data:image/jpeg;base64,'. $row['user_image'] .'"/>';
    }else{
     echo '<img class="profilePicture" src="user-default.jpg" alt="you"';
    }
    ?>    
    <br>
    
    <?php
    $user = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
    $userInfo = mysqli_fetch_array($user);
    $following=$userInfo['following'];
    $followarray=explode(",", $following); 
    if (in_array($_GET['friend'],$followarray)){

        echo '<form method="post" action=""><input type="submit" class="selectButtonWhite" name="unfollow" value="unfollow"><br>';
        echo '<input type="submit" class="selectButtonNarrow" name="message" value="message"></form><br>';

    }else{
        echo '<form method="post" action=""><input type="submit" class="selectButtonNarrow" name="follow" value="follow"></form><br>';

    }
    ?>

    <hr class='navbar'><br><br>


    <br><br>
    <?php while ($posts=mysqli_fetch_array($result2)){ 
        $linkname=$row['username'];
        $comments=$posts['comments'];
        $commArray=explode(",", $comments); 
        
        echo "<p class='center'>$linkname</a><br><br>";
        echo "<a class='center'>'".$posts['caption']."'</a><br>";
        echo '<img class="profilePic" src="'. $posts['image'].'"alt="you"><br><br>'; 
        echo '<form method="post" action=""><input type="hidden" name="postid" value='.$posts['id'].'>
            <input type="submit" name="like" class="rate" value="&hearts; '.$posts['likes'].'"/></form><br>';
        echo '<form class="center" method="post" action="">
            <input type="text" id="comment" name="comment" placeholder="say something...">  
            <input type="hidden" name="postid" value='.$posts['id'].'>
            <input type="submit" name="addcomment" value="add">
            </form><br>';
        for($i=0; $i<count($commArray); $i++){
            echo '<p class="center">'.$commArray[$i].'</p><br>';
        }
        echo "<hr class='navbar'><br><br><br><br>";
        }?>



    <br><br><br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function follow(){

        }
        function unfollow(){

        }
    </script>

</body>

</html>
