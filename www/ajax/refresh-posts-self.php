<?php

include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$row=mysqli_fetch_array($me);
$postsresults = mysqli_query($conn,"SELECT * FROM posts WHERE user_id='" . $_GET['user_id'] . "' ORDER BY id DESC");
$num=mysqli_query($conn,"SELECT * FROM numposts WHERE id=1");
$numres=mysqli_fetch_array($num);
$count=$numres['num'];
$newcount=mysqli_num_rows($postsresults);

//long poll here
while($newcount==$count){
    $postsresults = mysqli_query($conn,"SELECT * FROM posts WHERE user_id='" . $_GET['user_id'] . "' ORDER BY id DESC");
    $newcount=mysqli_num_rows($postsresults);
    sleep(2);
}

$retstring="";
while ($singlePost=mysqli_fetch_array($postsresults)){ 
    $user=$row['username'];
    $userimg;
    $link="./profile.php?user_id=" . $_GET['user_id'];
    if ($row['user_image']){
        $userimg=$row['user_image'];
    }else{
        $userimg="public/user-default.jpg";
    }
    $retstring.=$singlePost['id'].'@@'.$singlePost['caption'].'@@'.$user.'@@'.$link.'@@'.$singlePost['image'].'@@'.$singlePost['likes'].'@@'.$singlePost['comments'].'@@'.$userimg.'##';
}

mysqli_query($conn,"UPDATE numposts SET num='" . $newcount . "'");
echo $retstring;
?>