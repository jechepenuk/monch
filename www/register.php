<?php
   include_once "access-db.php";
   
   $message="";

   if(count($_POST)>0) {
       $username=$_POST['username'];
       $email=$_POST['email'];
       $pass=$_POST['paswd'];
       $pass2=$_POST['paswd2'];

       $result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "'");
       $count  = mysqli_num_rows($result);
       $result2 = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $_POST["username"] . "'");
       $count2  = mysqli_num_rows($result2);


       if($count2>0){
           $message="Username already in use.";
       }else if($count>0){
           $message="Email address is already in use.";
       }else if(!preg_match('(^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$)', $pass)){
           $message="Please enter a valid password.";
       }else if($pass!=$pass2){
           $message="Passwords do not match!";
       }else{
           $hash = password_hash($pass, PASSWORD_DEFAULT, array('cost' => 9));
           $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
           $stmt= $conn->prepare($sql);
           $stmt->bind_param("sss", $username, $email, $hash);
           $stmt->execute();

           $result1 = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "'");
           $row=mysqli_fetch_array($result1);
           $userid=$row['user_id'];
           $URL="http://localhost:8000/feed.php?user_id=" .$userid; 
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
    <title>monch register</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">

</head>
<body>
<div class="innerwrapper">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.html')">login</a> </li> -->
                <li><a class="navlink" href="./login.php">login</a> </li>
                <li>
                    <a class="navlink" href="./index.php">home</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.php">monch</a> </h2>
        </div>

    </div>

    <h1 class="welcome-page-title logsign">Sign Up</h1>
    <br>
    <div id="tutor_signup_div">
        <form method="post" action="">
            <div class="message">
                <?php 
                if($message!="") { 
                    echo $message; 
                } ?> 
            </div> 

            <label for="lname">Username *</label>
            <input class="sign_up_input" type="text" id= "username" name="username" placeholder="username" autofocus>
            <br>
            <label for="email"> Email *</label>
            <input class="sign_up_input" type="text" id= "email" name="email" placeholder="email">
            <br>
            <label for="password">Password *</label>
            <br>
            <label>Requires at least 8 characters, 1 uppercase, 1 lowercase, 1 special character and 1 number.</label>
            <input class="sign_up_input" type="password" id= "paswd" name="paswd" placeholder="password">
            <br>
            <label for="password">Confirm Password *</label>
            <input class="sign_up_input" type="password" id= "paswd2" name="paswd2" placeholder="confirm password">
            <br>
            <input type="submit" id="tutor_signup_submit" value= "Verify"> 
            <br><br><br>
        </form>

    </div>
</div>
    </body>
    </html>
    <?php ?>

