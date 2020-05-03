<?php

include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row=mysqli_fetch_array($me);
$postsresults = mysqli_query($conn,"SELECT * FROM posts WHERE user_id='" . $_GET['friend'] . "' ORDER BY id DESC");
$retstring="";
while ($singlePost=mysqli_fetch_array($postsresults)){ 
    $user=$row['username'];
    $userimg;
    $link="./friend-profile.php?user_id=" . $_GET['user_id'] . "&friend=".$_GET['friend'];
    if ($row['user_image']){
        $userimg=$row['user_image'];
    }else{
        $userimg="public/user-default.jpg";
    }
    $retstring.=$singlePost['id'].'@@'.$singlePost['caption'].'@@'.$user.'@@'.$link.'@@'.$singlePost['image'].'@@'.$singlePost['likes'].'@@'.$singlePost['comments'].'@@'.$userimg.'##';
}

echo $retstring;
?>