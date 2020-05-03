<?php
include_once "access-db.php";


$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);

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

}

if (($_POST['comment'])){
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
}
?>
