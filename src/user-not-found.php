<?php
$message="";
$userid=$_GET['user_id'];
include_once 'access-db.php';

if (isset($_POST['search'])){
    $username=$_POST['search'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $username . "'");
    if (mysqli_num_rows($result2)<1){
        header('Location: ./user-not-found.php?user_id='.$_GET['user_id']);
    }else{
        $user=mysqli_fetch_array($result2);
        header('Location: ./friend-profile.php?user_id='.$_GET['user_id'].'&friend='.$user['user_id']);
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
<body class="main-container">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="feed.php?user_id=<?php echo $userid;?>">feed</a> </li>
                <li><a class="navlink" href="profile.php?user_id=<?php echo $userid;?>">profile</a> </li>
                <li><a class="navlink" href="../index.php">logout</a> </li>


            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.php">Community Foods</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
        
        } ?> 
    </div> 
    <div class="center">
<br>
<br>
<h1 class="welcome-page-title">Oh no!</h1>
<h1 class="welcome-page-title">The profile you were looking for doesn't exist!</h1>
<h1 class="welcome-page-title">You can try searching again below!</h1><br><br><br>
<form method="post"><input class="log_in_input" type="text" name="search" placeholder="find a user..."></form>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <script>
        
    </script>

</body>

</html>
