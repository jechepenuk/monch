<?php
$message="";

include_once 'access-db.php';
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row = mysqli_fetch_array($result);
$friend=$row['username'];

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
if (isset($_POST['clear'])){
    $me=$_GET['user_id'];
    $friend=$_GET['friend'];
    $chat="";
    $result1=mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $me . "' and user2='" . $friend . "'");
    $result2 = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $friend . "' and user2='" . $me . "'");
    if (mysqli_num_rows($result1)>0){
        $row=mysqli_fetch_array($result1);
        mysqli_query($conn,"UPDATE messages SET chat='" . $chat . "' WHERE id='" . $row['id'] . "'"); 
    }
    else if(mysqli_num_rows($result2)>0){
        $row=mysqli_fetch_array($result2);
        mysqli_query($conn,"UPDATE messages SET chat='" . $chat . "', msgcount=0 WHERE id='" . $row['id'] . "'"); 
    }
    $URL="http://localhost:8000/chat.php?user_id=".$_GET['user_id']."&friend=".$_GET['friend']; 
    echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}
$link='friend-profile.php?user_id='.$_GET['user_id'].'&friend='.$_GET['friend']; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
    <link rel="stylesheet" type="text/css" href="css.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>CF</title>
    <script>
        function refreshchat() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var div=document.getElementById("cont");
                    var child=div.lastElementChild;
            
                    while (child){
                        div.removeChild(child);
                        child=div.lastElementChild;
                    }
                    var total=this.responseText;
                    if (total){
                        var arr=total.split("%%%");
                        var arrLen=arr.length;
                        for (var i=arrLen-1; i>=0; i--){
                            var paragraph=document.createElement("p");
                            var el=document.createTextNode(arr[i]);
                            paragraph.appendChild(el);
                            var d=document.getElementById("cont");
                            d.appendChild(paragraph);
                        }
                    }
                }
            };
            xmlhttp.open("GET", "ajax/refresh-chat.php?user_id=<?php echo $_GET['user_id'];?>&friend=<?php echo $_GET['friend'];?>", true);
            xmlhttp.send();
        }

        function sendFormData(){
            const formElement=document.getElementById("msg");
            const formData = new FormData(formElement);
            document.getElementById("msg").reset();
            const request= new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (this.readyState ===4 && this.status ===200){
                    console.log(this.responseText);
                    document.getElementById("chat").innerHTML=this.responseText;
                }
            };
            request.open("POST", "ajax/send-message.php?user_id=<?php echo $_GET['user_id'];?>&friend=<?php echo $_GET['friend'];?>");
            request.send(formData);
}
    </script>
</head>
<body class="main-container" onload="setInterval(refreshchat,500)">
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
    
    
    <h1 class="welcome-page-title">welcome to chat with <?php echo "<a class='linky' href='$link'>$friend</a><br><br>"; ?></h1>
    <br><br>
    <div style="width: 50%; margin-left: auto; margin-right: auto;">
    <form id="msg" action="" method="post" enctype="multipart/form-data" onsubmit="sendFormData();return false;">
        <input class="log_in_input" type="text" id="message" name="message" placeholder="say something"/>
        <input type="hidden" name="user" value="admin">

    </form>

    </div>
    <div id="cont" class="cont">
        <p id="chat"></p>

    </div>   
    <form method="post" action="">
        <input class="selectButton" type="submit" name="clear" id="clear" value="clear chat"/>
    </form>
    <br>
    <br>
    </div>


</body>

</html>
