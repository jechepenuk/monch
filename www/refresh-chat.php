<?php

include_once "access-db.php";
$me=$_GET['user_id'];
$friend=$_GET['friend'];
$result1=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' and user2='" . $friend . "'");
$result2 = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $friend . "' and user2='" . $me . "'");
if (mysqli_num_rows($result1)>0){
    $row2=mysqli_fetch_array($result1);
    echo $row2['chat'];
}

else if(mysqli_num_rows($result2)>0){
    $row=mysqli_fetch_array($result2);
    echo $row['chat'];
}
else{
    echo "no messages yet"; 
}

?>