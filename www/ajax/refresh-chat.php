<?php

include_once "access-db.php";
$me=$_GET['user_id'];
$friend=$_GET['friend'];
$chatid=$_GET['chat_id'];
$result1=mysqli_query($conn,"SELECT * FROM messages WHERE id='" . $chatid . "'");
$row2=mysqli_fetch_array($result1);
if($row2['chat']){
    echo $row2['chat'];
}else{
    echo "no messages yet"; 
}
mysqli_query($conn,"UPDATE messages SET new=0 WHERE id='" . $chatid . "'"); 
$result=mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $me . "'");
$row=mysqli_fetch_array($result);
if ($row['newmsg']==$friend){
    mysqli_query($conn,"UPDATE users SET newmsg=0 WHERE user_id='" . $me . "'"); 
}

?>