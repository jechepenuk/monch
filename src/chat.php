<?php
include_once 'access-db.php';
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row = mysqli_fetch_array($result);
$friend=$row['username'];
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

    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">feed</a> </li>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="../index.php">logout</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.php">Community Foods</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">

    <h1 class="welcome-page-title">welcome to chat with <?php echo $friend; ?></h1>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <script>
        
    </script>

</body>

</html>
