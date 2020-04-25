<?php
$message="";
include_once 'access-db.php';
if(count($_POST)>0) {
	$result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "' and password = '". $_POST["paswd"]."'");
	$count  = mysqli_num_rows($result);
	if($count==0) {
		$message = "Invalid email or password!";
	} else {

        $row = mysqli_fetch_array($result);
        $message = "You are successfully authenticated!";
        $var1=$row['user_id'];
        $URL="http://localhost:8000/feed.php?user_id=" .$var1; 
        echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
	}
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
    <title>CF</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>CF</title>
</head>

<body>
    <div class="header">
        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./register.php">create account</a> </li>
                <li><a class="navlink" href="./index.php">home</a> </li>
            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.php">Community Foods</a> </h2>
        </div>
    </div>
    <hr class="hr-navbar">

    <br>
    <br>
    <br>
    <h1 class="welcome-page-title">Log In</h1>

    <div id="tutor_signup_div">
        <form name="frmUser" method="post" action="">
        <div class="message">
                <?php 
                if($message!="") { 
                    echo $message; 
                } ?> 
            </div> 

            <label for="email">User Email</label>
            <input class="log_in_input" type="text" id="email" name="email" placeholder="Email">

            <label for="password">Password</label>
            <input class="log_in_input" type="password" id="password" name="paswd">
            
            <input id="log_in_button" name="submit" type="submit" value="Submit">
            <br>
            <br>
            <br>
        </form>
    </div>    
</body>
</html>
