<?php

include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);
$following=explode(",", $myinfo['following']);  
$postsresults = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");
$num=mysqli_query($conn,"SELECT * FROM numposts WHERE id=1");
$numres=mysqli_fetch_array($num);
$count=$numres['num'];
$newcount=mysqli_num_rows($postsresults);

//long poll here
while($newcount==$count){
    $postsresults = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");
    $newcount=mysqli_num_rows($postsresults);
    sleep(2);
}

$retstring="";
while ($singlePost=mysqli_fetch_array($postsresults)){ 
    if (in_array($singlePost['user_id'], $following) || $singlePost['user_id']==$_GET['user_id'] ){
        $usr = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $singlePost['user_id'] . "'");
        $row = mysqli_fetch_array($usr);
        $user=$row['username'];
        $userimg;
        if ($_GET['user_id']==$singlePost['user_id']){
            $link="./profile.php?user_id=" . $_GET['user_id'];
        }else{
            $link="./friend-profile.php?user_id=".$_GET['user_id']. "&friend=" . $singlePost['user_id'];
        }
        if ($row['user_image']){
            $userimg="public/user-default.jpg";
        }else{
            $userimg="public/user-default.jpg";
        }
        $retstring.=$singlePost['id'].'@@'.$singlePost['caption'].'@@'.$user.'@@'.$link.'@@'.$singlePost['image'].'@@'.$singlePost['likes'].'@@'.$singlePost['comments'].'@@'.$userimg.'##';
    }
}
mysqli_query($conn,"UPDATE numposts SET num='" . $newcount . "'");
echo $retstring;
?>