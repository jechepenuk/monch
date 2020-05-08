<?php
$message="";

include_once 'access-db.php';
$userid=$_GET['user_id'];

if (isset($_POST['submit'])) {
    $caption=$_POST['caption'];
    $caption=htmlspecialchars($caption);
    if (!getimagesize($_FILES['imagefile']['tmp_name'])){
        echo "<br>Please choose a file or choose a file under 2MB.";
    } else {
        $target_dir = "public/";
        $temp_name = $_FILES['imagefile']['tmp_name'];
        $name = $_FILES['imagefile']['name'];
        $path = pathinfo($name);
        $filename=$path['filename'];
        $ext=$path['extension'];
        $location=$target_dir.$filename.".".$ext;

        move_uploaded_file($temp_name,$location);
        $sql = "INSERT INTO posts (`caption`, `user_id`, `image`) VALUES ('".$caption."', '".$userid."','".$location."')";
        $r=mysqli_query($conn,$sql);
        if (!$r){
            echo mysqli_error($conn);
        }else{
        $URL="http://localhost:8000/feed.php?user_id=" .$userid; 
        echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
    }}
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
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
    <title>monch upload</title>
    <script>
        function display(file){
            console.log(file);
        }
    </script>
</head>
<body class="main-container">
<div class="innerwrapper">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./messages.php?user_id=<?php echo $_GET['user_id'];?>">messages</a> </li>
                <li><a class="navlink" href="profile.php?user_id=<?php echo $userid;?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a> </li>
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>


            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">monch</a> </h2>
        </div>

    </div>
    <h1 class="welcome-page-title">What are you eating?</h1>

    <div class="message">

    
    <?php if($message!="") { 
        echo $message; 
        
        } ?> 
    </div> 
    <div class="center">
<br>
<br>
<br>
<br>
<div class="cont">
    <form method="post" action="" enctype="multipart/form-data">
            <input class="log_in_input" type="text" name="caption" placeholder="add a caption..."><br><br>
            <input class="log_in_input" accept="image/*" type="file" name="imagefile" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"><br><br>
            <img class="feedPic" id="output" src="" alt="no photo chosen">
            <input class="selectButton" type="submit" name="submit" value="post">
        </form>
    </div>
</div>
<br><br><br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    </div>
</body>

</html>
