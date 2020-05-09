<?php

include_once "access-db.php";
//remove the notification here!
$me=$_GET['user_id'];
$myf=mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $me ."'");
$myinfo=mysqli_fetch_array($myf);

$r=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' or user2='" . $me . "'");
$cc=mysqli_num_rows($r);
mysqli_query($conn,"UPDATE users SET convos='" . $cc . "' WHERE user_id='" . $me . "'"); 

$result = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $_GET['user_id'] . "' or user2='" .$_GET['user_id'] . "'");
if (isset($_POST['search2'])){
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
    <link rel="stylesheet" type="text/css" href="css.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
    <title>monch messages</title>
</head>
<body class="main-container">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a> </li>
                <li><form method="post">
                    <input type="text" name="search" placeholder="find a user">
                    <input class="smallgo" type="submit" name="search2" value="go">
                </form>
                </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">monch</a> </h2>
        </div>

    </div>
    <div class="innerwrapper">

    <h1 class="welcome-page-title">Your Chats</h1>
    <br> 
    <br>
    <div class="cont">

    <?php 
    if (mysqli_num_rows($result)==0){
        echo "<p class='center'>You have no conversations yet. Search for a profile to start one.</p>";
    }else{
    while ($row=mysqli_fetch_array($result)){
        if ($row['user1']==$_GET['user_id']){
            $result2=mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $row['user2'] . "'");
            $user=mysqli_fetch_array($result2);
            $linkname=$user['username'];
            $msgid=$row['id'];
            $link="chat.php?user_id=".$_GET['user_id']."&friend=".$row['user2']."&chat_id=".$msgid;
            if ($myinfo['newmsg']==$row['user2']){
                echo "<a class='chatlink blink_me bold_me' href=".$link.">$linkname</a><br><br>";
            }else{
                echo "<a class='chatlink' href=".$link.">$linkname</a><br><br>";
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $row['user1'] . "'");
            $user=mysqli_fetch_array($result2);
            $msgid=$row['id'];
            $linkname=$user['username'];
            $link="chat.php?user_id=".$_GET['user_id']."&friend=".$row['user1']."&chat_id=".$msgid;
            if($myinfo['newmsg']==$row['user1']){
                echo "<a class='chatlink blink_me bold_me' href=".$link.">$linkname</a><br><br>";
            }else{
                echo "<a class='chatlink' href=".$link.">$linkname</a><br><br>";
            }
        }
    }
}
    ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


</body>

</html>
