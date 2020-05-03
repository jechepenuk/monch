<?php
$message="";

include_once "access-db.php";
$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);
$following=explode(",", $myinfo['following']);  
$postsresults = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");

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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script>
        function loadposts() {
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
                    var arr=total.split("##");
                    var arrLen=arr.length;
                    for (var i=0; i<arrLen-1; i++){
                        var post=arr[i].split("@@");
                        var br = document.createElement("br");
                        var br1 = document.createElement("br");
                        var br2 = document.createElement("br");
                        var br3 = document.createElement("br");
                        var br4 = document.createElement("br");
                        var smallPic=document.createElement("img");
                        smallPic.className="smallPic";
                        smallPic.src=post[7];
                        var userlink = document.createElement("a");
                        userlink.className="proflink";
                        userlink.href=post[3]; 
                        var el=document.createTextNode(post[2]);
                        userlink.appendChild(el);                        
                        var image=document.createElement("img");
                        image.className="feedPic";
                        image.src=post[4];
                        var caption = document.createElement("a");
                        caption.className="center";
                        var ele=document.createTextNode(post[1]);
                        caption.appendChild(ele);  
                        var form=document.createElement("form");
                        form.className="center";
                        form.method="post";
                        form.action="";
                        form.id="updatepost";
                        form.onsubmit="sendFormData();return false;";
                        form.enctype="multipart/form-data";
                        var comInput=document.createElement("input");
                        comInput.className="log_in_input";
                        comInput.name="comment";
                        comInput.type="text";
                        comInput.placeholder="say something...";
                        var hidden=document.createElement("input");
                        hidden.type="hidden";
                        hidden.name="postid";
                        hidden.value=post[0];
                        var likeInput=document.createElement("input");
                        likeInput.className="rate";
                        likeInput.type="button";
                        likeInput.name="like";
                        likeInput.value=post[5];
                        likeInput.id="like";
                        form.appendChild(comInput);
                        form.appendChild(hidden);
                        form.appendChild(likeInput);
                        var com=document.createElement("p");
                        com.className="center";
                        com.id="comment";
                        com.name="comment";
                        var info=document.createTextNode(post[6]);
                        com.appendChild(info);
                        var d=document.getElementById("cont");
                                               
                        d.appendChild(smallPic);
                        d.appendChild(userlink);
                        d.appendChild(caption);
                        d.appendChild(br);
                        d.appendChild(image);
                        d.appendChild(form);
                        d.appendChild(br4);
                        d.appendChild(com);
                        d.appendChild(br1);
                        d.appendChild(br2);
                        // d.appendChild(br3);
                        // console.log(post[6]);
                        // // com.className="center";
                        // var commArray=post[6].split(",");
                        // console.log(commArray.length);
                        // for (var i=0; i<commArray.length; i++){
                        //     var com=document.createElement("p");
                        //     var info=document.createTextNode(commArray[i]);
                        //     com.appendChild(info);
                        //     d.appendChild(com);
                        // }
                    }
                }
            };
            xmlhttp.open("GET", "load-posts.php?user_id=<?php echo $_GET['user_id'];?>", true);
            xmlhttp.send();
        }
        refreshposts();

        function refreshposts() {
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
                    console.log(total);
                    var arr=total.split("##");
                    var arrLen=arr.length;
                    for (var i=0; i<arrLen-1; i++){
                        var post=arr[i].split("@@");
                        var br = document.createElement("br");
                        var br1 = document.createElement("br");
                        var br2 = document.createElement("br");
                        var br3 = document.createElement("br");
                        var br4 = document.createElement("br");
                        var smallPic=document.createElement("img");
                        smallPic.className="smallPic";
                        smallPic.src=post[7];
                        var userlink = document.createElement("a");
                        userlink.className="proflink";
                        userlink.href=post[3]; 
                        var el=document.createTextNode(post[2]);
                        userlink.appendChild(el);                        
                        var image=document.createElement("img");
                        image.className="feedPic";
                        image.src=post[4];
                        var caption = document.createElement("a");
                        caption.className="center";
                        var ele=document.createTextNode(post[1]);
                        caption.appendChild(ele);  
                        var form=document.createElement("form");
                        form.className="center";
                        form.method="post";
                        form.action="";
                        form.id="updatepost";
                        form.onsubmit="sendFormData();return false;";
                        form.enctype="multipart/form-data";
                        var comInput=document.createElement("input");
                        comInput.className="log_in_input";
                        comInput.name="comment";
                        comInput.type="text";
                        comInput.placeholder="say something...";
                        var hidden=document.createElement("input");
                        hidden.type="hidden";
                        hidden.name="postid";
                        hidden.value=post[0];
                        var likeInput=document.createElement("input");
                        likeInput.className="rate";
                        likeInput.type="button";
                        likeInput.name="like";
                        likeInput.value=post[5];
                        likeInput.id="like";
                        form.appendChild(comInput);
                        form.appendChild(hidden);
                        form.appendChild(likeInput);
                        var com=document.createElement("p");
                        com.className="center";
                        com.id="comment";
                        com.name="comment";
                        var info=document.createTextNode(post[6]);
                        com.appendChild(info);
                        var d=document.getElementById("cont");
                                               
                        d.appendChild(smallPic);
                        d.appendChild(userlink);
                        d.appendChild(caption);
                        d.appendChild(br);
                        d.appendChild(image);
                        d.appendChild(form);
                        d.appendChild(br4);
                        d.appendChild(com);
                        d.appendChild(br1);
                        d.appendChild(br2);
                        // d.appendChild(br3);
                        // console.log(post[6]);
                        // // com.className="center";
                        // var commArray=post[6].split(",");
                        // console.log(commArray.length);
                        // for (var i=0; i<commArray.length; i++){
                        //     var com=document.createElement("p");
                        //     var info=document.createTextNode(commArray[i]);
                        //     com.appendChild(info);
                        //     d.appendChild(com);
                        // }
                    }
                }
            };
            xmlhttp.open("GET", "refresh-posts.php?user_id=<?php echo $_GET['user_id'];?>", true);
            xmlhttp.send();
        }
        refreshposts();

        function sendFormData(){
            const formElement=document.getElementById("updatepost");
            const formData = new FormData(formElement);
            document.getElementById("updatepost").reset();
            const request= new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (this.readyState ===4 && this.status ===200){
                    console.log(this.responseText);
                    // document.getElementById("like").innerHTML=this.responseText;
                    // document.getElementById("comment").innerHTML=this.responseText;
                }
            };
            request.open("POST", "update-post.php?user_id=<?php echo $_GET['user_id'];?>");
            request.send(formData);
        }
    </script>
</head>

<!-- <body onload="setInterval(refreshposts, 2000)"> -->
<body onload=loadposts()>
    <div class="innerwrapper">
    <div class="header">

        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./messages.php?user_id=<?php echo $_GET['user_id'];?>">messages</a> </li>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id'];?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a></li>
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
    <h1 class="welcome-page-title">Welcome back, <?php echo $myinfo['username'];?>.</h1>

    <button class="selectButtonNarrow" onclick="window.location.href = './upload.php?user_id=<?php echo $_GET['user_id']; ?>'">add post</button><br><br>
    <hr class='navbar'><br><br>

    <div class="cont" id="cont">
    </div>

</body>

