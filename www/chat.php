<?php
$message="";

include_once 'access-db.php';
$chatid=$_GET['chat_id'];
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row = mysqli_fetch_array($result);
$friend=$row['username'];
$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$row2 = mysqli_fetch_array($me);
$my_name=$row2['username'];
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
    $URL="http://localhost:8000/chat.php?user_id=".$_GET['user_id']."&friend=".$_GET['friend']."&chat_id=".$chatid; 
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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
    <title>monch chat</title>
    <script>
        function refreshchat() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var div=document.getElementById("c");
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
                            if(arr[i].includes("<?php echo $my_name;?>")){
                                var paragraph=document.createElement("p");
                                paragraph.className="messagetext";
                                var el=document.createTextNode(arr[i]);
                                paragraph.appendChild(el);
                                var d=document.getElementById("c");
                                d.appendChild(paragraph);
                                }
                            else{
                                var paragraph=document.createElement("p");
                                paragraph.className="messagetext2";
                                var el=document.createTextNode(arr[i]);
                                paragraph.appendChild(el);
                                var d=document.getElementById("c");
                                d.appendChild(paragraph);
                            }
                            
                        }
                    }
                }
            };
            xmlhttp.open("GET", "ajax/refresh-chat.php?user_id=<?php echo $_GET['user_id'];?>&friend=<?php echo $_GET['friend'];?>&chat_id=<?php echo $chatid;?>", true);
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
<body class="main-container" onload="setInterval(refreshchat,1500)">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a> </li>
<<<<<<< HEAD
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>
=======
                <li><form method="post">
                    <input type="text" name="search" placeholder="find a user">
                    <input class="smallgo" type="submit" name="search2" value="go">
                </form>
                </li>


>>>>>>> d5588eff4f3b6bce729d2fab8bcb144d5faad57b
            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">monch</a> </h2>
        </div>

    </div>
    
    <div class="innerwrapper">

    <h1 class="welcome-page-title">Chatting with <?php echo "<a class='linky' href='$link'>$friend</a><br><br>"; ?></h1>
    <br><br>
    <div class="cont">
    <form id="msg" action="" method="post" enctype="multipart/form-data" onsubmit="sendFormData();return false;">
        <input class="cominput" type="text" id="message" name="message" placeholder="say something"/>
        <input class="post" type="submit" name="message1" value="Send">
        <input type="hidden" name="user" value="admin">

    </form>

    <div id="c">
        <p id="chat"></p>

    </div> 
    </div>  
    <form method="post" action="">
        <input class="selectButton" type="submit" name="clear" id="clear" value="clear chat"/>
    </form>
    <br>
    <br>
    </div>


</body>

</html>
