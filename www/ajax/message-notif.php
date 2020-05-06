<?php

include_once "access-db.php";


//look through all messages for the user and track mesage count
//if any values change or the count of the conversations changes
//echo new message, clicking takes you to the chat.
$me=$_GET['user_id'];
$result=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' or user2='" . $me . "'");
$cc=mysqli_num_rows($result);
$myinfo=mysqli_fetch_array($result);
$oldCount=$myinfo['convos'];

echo "";

while($cc==$oldCount){
    $result1=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' or user2='" . $me . "'");
    $cc=mysqli_num_rows($result1);
    sleep(2);
}

echo "new message!";

?>