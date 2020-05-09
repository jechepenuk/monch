<?php
include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);

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

echo $_POST['postid'];


?>