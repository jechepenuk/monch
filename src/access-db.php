<?php
$servername = "localhost";
$username = "user";
$password = "887BAE32x$";
$db = "social-media";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
 
