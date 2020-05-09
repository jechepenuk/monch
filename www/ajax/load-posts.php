<?php

include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);
$following=explode(",", $myinfo['following']);  
$counts = array_count_values($following);
$postsresults = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");

if($myinfo['newmsg']!=0){
    $result = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $_GET['user_id'] . "' and user2='" .$myinfo['newmsg'] . "' or user2='" . $_GET['user_id'] . "' and user1='" .$myinfo['newmsg'] . "'");
    $row=mysqli_fetch_array($result);
    $chatid=$row['id'];
    $retstring=$myinfo['newmsg'].",".$chatid."$$";
}else{
    $retstring="";
}
while ($singlePost=mysqli_fetch_array($postsresults)){ 
    $count=$counts[$singlePost['user_id']];
    if ($count % 2 == 1 || $singlePost['user_id']==$_GET['user_id'] ){
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
            $userimg=$row['user_image'];
        }else{
            $userimg="public/user-default.jpg";
        }
        $retstring.=$singlePost['id'].'@@'.$singlePost['caption'].'@@'.$user.'@@'.$link.'@@'.$singlePost['image'].'@@'.$singlePost['likes'].'@@'.$singlePost['comments'].'@@'.$userimg.'##';
    }
}
echo $retstring;
?>