<?php
include_once "access-db.php";

$me=$_GET['user_id'];
$friend=$_GET['friend'];
$result1=mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $me . "'");
$row=mysqli_fetch_array($result1);
$username=$row['username'];
$name=$username.": ";
$separator='%%%';

if ($_POST['message']){
    $mess=htmlspecialchars($_POST['message']);
    $message=$name.$mess.$separator;

    $result1=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' and user2='" . $friend . "'");
    $result2 = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $friend . "' and user2='" . $me . "'");

    if (mysqli_num_rows($result1)>0){
        $row=mysqli_fetch_array($result1);
        $chat= $row['chat'];
        $chat.=$message;
        $newcount=$row['msgcount'] +1;
        mysqli_query($conn,"UPDATE messages SET chat='" . $chat . "', msgcount='" .$newcount. "' WHERE user1='" . $me . "' and user2='" . $friend . "'"); 

    }else if (mysqli_num_rows($result2)>0){
        $row=mysqli_fetch_array($result2);
        $chat= $row['chat'];
        $chat.=$message;
        $newcount=$row['msgcount'] +1;
        mysqli_query($conn,"UPDATE messages SET chat='" . $chat . "', msgcount='" .$newcount. "' WHERE user2='" . $me . "' and user1='" . $friend . "'"); 

    }else{
        $sql = "INSERT INTO messages (user1, user2, chat, msgcount) VALUES (?,?,?,?)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("iisi", $me, $friend, $message, 1);
        $stmt->execute();

    }
    mysqli_query($conn,"UPDATE users SET newmsg='".$me."' WHERE user_id='" . $friend . "'"); 

    echo $message;
}
?>
