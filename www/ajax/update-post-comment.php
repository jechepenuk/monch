<?php
include_once "access-db.php";

$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);

if (($_POST['comment'])){
    $postid=$_POST['postid'];
    $commenter=$_GET['user_id'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $commenter . "'");
    $row2 = mysqli_fetch_array($result2);
    $commenter=$row2['username'];
    $comment=$_POST['comment'];
    $comment=htmlspecialchars($comment);
    $post = mysqli_query($conn,"SELECT * FROM posts WHERE id='" . $postid . "'");
    $postinfo=mysqli_fetch_array($post);
    $currComments=$postinfo['comments'];
    $updatedComments;
    if (!$currComments){
        $updatedComments=$commenter . ': ' . $comment;
    }else{
        $updatedComments=$currComments . ',   ' . $commenter . ': ' . $comment;
    }
    $numcom=$postid['numcomments']+1;
    mysqli_query($conn,"UPDATE posts SET comments='" . $updatedComments . "', numcomments='" . $numcom . "'  WHERE id='" . $postid . "'"); 
    // $URL="http://localhost:8000/feed.php?user_id=".$_GET['user_id']; 
    // echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}
echo $_POST['postid'];
?>
