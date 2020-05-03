<?php
$message="";
include_once 'access-db.php';
if(count($_POST)>0) {
    $pass=$_POST['paswd'];
	$result = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $_POST["username"] . "'");
	$count  = mysqli_num_rows($result);
	if($count==0) {
		$message = "Invalid username or password!";
	} else {
        $row = mysqli_fetch_array($result);
        if (password_verify($pass,$row['password'])){
            $var1=$row['user_id'];
            $URL="http://localhost:8000/feed.php?user_id=" .$var1; 
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
        }else{
            $message = "Invalid username or password!";
        }

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
    <div class="main-container">
    <div class="innerwrapper">
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

            <label for="email">Username</label><br>
            <input class="log_in_input" type="text" id="username" name="username" placeholder="username" autofocus>
            <br>
            <label for="password">Password</label><br>
            <input class="log_in_input" type="password" id="password" name="paswd" placeholder="password">
            
            <input id="log_in_button" name="submit" type="submit" value="Submit">
            <br>
            <br>
            <br>
        </form>
    </div> 
    </div>   
</body>
</html>
