<?php
$message="";

include_once 'access-db.php';
if (isset($_POST['submit'])) {
    $userid=$_GET['user_id'];
    if (getimagesize($_FILES['imagefile']['tmp_name']) == false) {
        echo "<br />Please Select An Image.";
    } else {
        $target_dir = "public/";
        $temp_name = $_FILES['imagefile']['tmp_name'];
        $name = $_FILES['imagefile']['name'];
        $path = pathinfo($name);
        $filename=$path['filename'];
        $ext=$path['extension'];
        $location=$target_dir.$filename.".".$ext;
        move_uploaded_file($temp_name,$location);

        mysqli_query($conn, "UPDATE users SET  user_image='" . $location . "' WHERE user_id='" . $userid . "'");

    }
    $URL="http://localhost:8000/profile.php?user_id=" .$userid; 
    echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}
if (isset($_POST['search'])){
    $username=$_POST['search'];
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $username . "'");
    if (mysqli_num_rows($result2)<1){
        $URL="http://localhost:8000/user-not-found.php?user_id=".$_GET['user_id']; 
        echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
    }else{
        $user=mysqli_fetch_array($result2);
        if ($user['user_id']==$_GET['user_id']){
            $URL="http://localhost:8000/profile.php?user_id=".$_GET['user_id']; 
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
        }else{
            $URL="http://localhost:8000/friend-profile.php?user_id=".$_GET['user_id'].'&friend='.$user['user_id']; 
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
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
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>CF</title>
</head>
<body class="main-container">
<div class="innerwrapper">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">feed</a> </li>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a> </li>
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>


            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.php">Community Foods</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
        
        } ?> 
    </div> 
    <br>
<br>
    <div class="cont">
    <p class="center">-file size should not exceed 2MB-</p><br><br>
        <form method="post" action="" enctype="multipart/form-data">
            <input class="log_in_input" type="file" name="imagefile">
            <input class="selectButton" type="submit" name="submit" value="Upload">
        </form>
    </div>

</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


</body>

</html>
