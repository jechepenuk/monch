<?php
$message="";

include_once "access-db.php";
$userid=$_GET['user_id'];
$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);

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
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <title>monch feed</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">
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
                    var msg=total.split("$$");
                    if (msg.length>1){
                        var div=document.getElementById("update");
                        var child=div.lastElementChild;
                        while (child){
                            div.removeChild(child);
                            child=div.lastElementChild;
                        }   
                        var paragraph=document.createElement("a");
                        paragraph.href="./messages.php?user_id=<?php echo $_GET['user_id'];?>";
                        paragraph.className="navlink blink_me bold_me";
                        var el=document.createTextNode(msg[0]);
                        paragraph.appendChild(el);
                        div.appendChild(paragraph);

                    }
                    var x;
                    if (msg.length>1){
                        x=msg[1];
                    }else{
                        x=msg;
                    }
                    var x = x.toString();
                    var arr=x.split("##")
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
                        var fo=document.createElement("form");
                        fo.className="center";
                        fo.method="post";
                        fo.enctype="multipart/form-data";
                        var comInput=document.createElement("input");
                        comInput.className="log_in_input";
                        comInput.name="comment";
                        comInput.type="text";
                        comInput.id="comm";
                        comInput.placeholder="say something...";
                        var hidden=document.createElement("input");
                        hidden.type="hidden";
                        hidden.name="postid";
                        var postid;
                        if (i==0 && msg.length==1){
                            posts=post[0].split("\n");
                            postid=posts[1]
                            hidden.value=postid;
                        }else{
                            postid=post[0];
                            hidden.value=postid;  
                        }
                        var ident="updatepost" + postid;
                        fo.id=ident;
                        fo.onsubmit=sendFormDataComment;

                        var f=document.createElement("form");
                        f.className="center";
                        f.method="post";
                        f.enctype="multipart/form-data";

                        var hiddenlike=document.createElement("input");
                        hiddenlike.type="hidden";
                        hiddenlike.name="postid";
     
                        var ident="updatepost" + postid;
                        f.id=ident;
                        f.onsubmit=sendFormDataLike;
                        var likeInput=document.createElement("input");
                        likeInput.className="rate";
                        likeInput.type="submit";
                        likeInput.name="like";
                        likeInput.value=post[5];
                        likeInput.id="like";
                        fo.appendChild(comInput);
                        fo.appendChild(hidden);
                        f.appendChild(likeInput);
                        f.appendChild(hiddenlike)
                        var d=document.getElementById("cont");
               
                        d.appendChild(smallPic);
                        d.appendChild(userlink);
                        d.appendChild(caption);
                        d.appendChild(br);
                        d.appendChild(image);
                        d.appendChild(fo);
                        d.appendChild(f);
                        d.appendChild(br4);

                        var com=document.createElement("p");
                        var info=document.createTextNode(post[6]);
                        com.className="center";
                        com.appendChild(info);
                        d.appendChild(com);
                        d.appendChild(br1);
                        d.appendChild(br2);
                    }
                }
            };
            xmlhttp.open("GET", "ajax/load-posts.php?user_id=<?php echo $_GET['user_id'];?>", true);
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
                    var msg=total.split("$$");
                    if (msg.length>1){
                        var div=document.getElementById("update");
                        var child=div.lastElementChild;
                        while (child){
                            div.removeChild(child);
                            child=div.lastElementChild;
                        }   
                        var paragraph=document.createElement("a");
                        paragraph.href="./messages.php?user_id=<?php echo $_GET['user_id'];?>";
                        paragraph.className="navlink blink_me bold_me";
                        var el=document.createTextNode(msg[0]);
                        paragraph.appendChild(el);
                        div.appendChild(paragraph);

                    }
                    var x;
                    if (msg.length>1){
                        x=msg[1];
                    }else{
                        x=msg;
                    }
                    var x = x.toString();
                    var arr=x.split("##")
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
                        var fo=document.createElement("form");
                        fo.className="center";
                        fo.method="post";
                        fo.enctype="multipart/form-data";
                        var comInput=document.createElement("input");
                        comInput.className="log_in_input";
                        comInput.name="comment";
                        comInput.type="text";
                        comInput.id="comm";
                        comInput.placeholder="say something...";
                        var hidden=document.createElement("input");
                        hidden.type="hidden";
                        hidden.name="postid";
                        var postid;
                        if (i==0 && msg.length==1){
                            posts=post[0].split("\n");
                            postid=posts[1]
                            hidden.value=postid;
                        }else{
                            postid=post[0];
                            hidden.value=postid;  
                        }
                        var ident="updatepost" + postid;
                        fo.id=ident;
                        fo.onsubmit=sendFormDataComment;

                        var f=document.createElement("form");
                        f.className="center";
                        f.method="post";
                        f.enctype="multipart/form-data";

                        var hiddenlike=document.createElement("input");
                        hiddenlike.type="hidden";
                        hiddenlike.name="postid";
     
                        var ident="updatepost" + postid;
                        f.id=ident;
                        f.onsubmit=sendFormDataLike;
                        var likeInput=document.createElement("input");
                        likeInput.className="rate";
                        likeInput.type="submit";
                        likeInput.name="like";
                        likeInput.value=post[5];
                        likeInput.id="like";
                        fo.appendChild(comInput);
                        fo.appendChild(hidden);
                        f.appendChild(likeInput);
                        f.appendChild(hiddenlike)
                        var d=document.getElementById("cont");
               
                        d.appendChild(smallPic);
                        d.appendChild(userlink);
                        d.appendChild(caption);
                        d.appendChild(br);
                        d.appendChild(image);
                        d.appendChild(fo);
                        d.appendChild(f);
                        d.appendChild(br4);

                        var com=document.createElement("p");
                        var info=document.createTextNode(post[6]);
                        com.className="center";
                        com.appendChild(info);
                        d.appendChild(com);
                        d.appendChild(br1);
                        d.appendChild(br2);
                    }
                }
            };
            xmlhttp.open("GET", "ajax/refresh-posts.php?user_id=<?php echo $_GET['user_id'];?>", true);
            xmlhttp.send();
        }
        refreshposts();

        function sendFormDataComment(elem){
            event.preventDefault();
            if(document.getElementById(elem.target.id)){
                const formElement=document.getElementById(elem.target.id);
                const formData = new FormData(formElement);
                document.getElementById(elem.target.id).reset();
                const request= new XMLHttpRequest();
                request.onreadystatechange = function(){
                    if (this.readyState ===4 && this.status ===200){
                        console.log(this.responseText);
                        loadposts();
                    }
                };
                request.open("POST", "ajax/update-post-comment.php?user_id=<?php echo $_GET['user_id'];?>");
                request.send(formData);
            }

        }

        function sendFormDataLike(elem){
            event.preventDefault();
            const formElement=document.getElementById(elem.target.id);
            const formData = new FormData(formElement);
            document.getElementById(elem.target.id).reset();
            const request= new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (this.readyState ===4 && this.status ===200){
                    console.log(this.responseText);
                    loadposts();
                }
            };
            request.open("POST", "ajax/update-post-like.php?user_id=<?php echo $_GET['user_id'];?>");
            request.send(formData);
        }
    </script>
</head>

<body onload=loadposts() class="main-container" >
    <div class="innerwrapper">
    <div class="header">
        <div class="menu_welcomePage">
            <ul>
                <li id="update"></li>
                <li><a class="navlink" href="./messages.php?user_id=<?php echo $_GET['user_id'];?>">messages</a> </li>
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id'];?>">profile</a> </li>
                <li><a class="navlink" href="./index.php">logout</a></li>
                <li><form method="post"><input class="searchform" type="text" name="search" placeholder="find a user"></form></li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./feed.php?user_id=<?php echo $_GET['user_id'];?>">monch</a> </h2>
        </div>
    </div>

    <!-- <hr class="hr-navbar"> -->
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
    } ?> 
    </div> 
    <h1 class="welcome-page-title">Welcome back, <?php echo $myinfo['username'];?></h1>

    <button class="selectButtonNarrow" onclick="window.location.href = './upload.php?user_id=<?php echo $_GET['user_id']; ?>'">add post</button><br><br>
    <br><br>

    <?php if(!$myinfo['following']){
        echo "<h3 class='center'>You are not following anyone yet!</h3><br>";
        echo "<h3 class='center'>Try following one of these profiles to get you started:</h3><br>";
        echo "<a class='proflink' href='friend-profile.php?user_id=$userid&friend=1'>jane_doe</a><br>";
        echo "<a class='proflink' href='friend-profile.php?user_id=$userid&friend=2'>fake_user</a><br>";
        echo "<a class='proflink' href='friend-profile.php?user_id=$userid&friend=3'>guy_fieri</a><br><br><hr class='navbar'><br><br>";

    }
?>
    <div class="cont" id="cont">
    </div>

    

</body>

