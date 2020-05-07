<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
    <title>monch home</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
</head>

<body class="main-container">
<div class="innerwrapper">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.php')">login</a> </li> -->
                <li><a class="navlink" href="login.php">login</a> </li>
                <li><a class="navlink" href="register.php">register</a></li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.php">monch</a> </h2>
        </div>

    </div>

    <h1 class="welcome-page-title main">welcome to monch</h1>
    <br><br>
    <h2 class="newheader">a destination for every food lover...</h2><br>
    <h2 class="newheader">share your food with us!</h2>



    <br><br><br><br><br><br><br><br><br>
        <button class="big" onclick="window.location.href = 'login.php'">Log In</button>
        <button class= "big" onclick="window.location.href = 'register.php'">Register</button>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <script>
    </script>
</div>
</body>

</html>
