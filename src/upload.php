<?php
include_once 'access-db.php';
$userid=$_GET['user_id'];

if (isset($_POST['submit'])) {
    $caption=$_POST['caption'];
    if (getimagesize($_FILES['imagefile']['tmp_name']) == false) {
        echo "<br />Please choose a file.";
    } else {
        $target_dir = "public/";
        $temp_name = $_FILES['imagefile']['tmp_name'];
        $name = $_FILES['imagefile']['name'];
        $path = pathinfo($name);
        $filename=$path['filename'];
        $ext=$path['extension'];
        $mime = $_FILES['imagefile']['type'];   
        $location=$target_dir.$filename.".".$ext;
        move_uploaded_file($temp_name,$location);
        $sql = "INSERT INTO posts (`caption`, `user_id`, `image`, `mime`) VALUES ('".$caption."', '".$userid."','".$location."','".$mime."' )";
        mysqli_query($conn,$sql);
        header('Location: ./feed.php?user_id=' . $userid);
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

    <div class="center">
<br>
<br>
    <form method="post" action="" enctype="multipart/form-data">
            <input type="text" name="caption" placeholder="say something...">
            <input type="file" name="imagefile">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <script>
        
    </script>

</body>

</html>
