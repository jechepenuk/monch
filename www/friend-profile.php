<?php
$message="";

include_once "access-db.php";
$me = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
$myinfo=mysqli_fetch_array($me);
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['friend'] . "'");
$row = mysqli_fetch_array($result);
$result2 = mysqli_query($conn,"SELECT * FROM posts WHERE user_id='" . $_GET['friend'] . "' ORDER BY id DESC ");

if (isset($_POST['follow']) || isset($_POST['unfollow'])){
    $result2 = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
    $row2 = mysqli_fetch_array($result2);
    $following=$row2['following'];
    $updatedFollow=$following . ','.$_GET['friend'];
    mysqli_query($conn,"UPDATE users SET following='" . $updatedFollow . "' WHERE user_id='" . $_GET['user_id'] . "'"); 
    $URL="http://localhost:8000/friend-profile.php?user_id=" . $_GET['user_id'] . '&friend=' . $_GET['friend']; 
    echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
}

if (isset($_POST['message'])){
    $result = mysqli_query($conn,"SELECT * FROM messages WHERE user1='" . $_GET['user_id'] . "' and user2='" .$_GET['friend'] . "' or user1='" . $_GET['friend'] . "' and user2='" .$_GET['user_id'] . "'");
    if (mysqli_num_rows($result)==0){
        $sql = "INSERT INTO messages (user1, user2) VALUES (?,?)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $_GET['user_id'], $_GET['friend']);
        $stmt->execute();
        
    }else{
        $row=mysqli_fetch_array($result);
        if ($row['user1']==$_GET['user_id']){
            $msgid=$row['id'];
            $link="chat.php?user_id=".$_GET['user_id']."&friend=".$row['user2']."&chat_id=".$msgid;
            $URL=$link;
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
            
        }else{
            $msgid=$row['id'];
            $link="chat.php?user_id=".$_GET['user_id']."&friend=".$row['user2']."&chat_id=".$msgid;
            $URL=$link;
            echo "<script type='text/javascript'>document. location. href='{$URL}';</script>"; echo '<META HTTP-EQUIV="refresh" content="0;URL=';
            }
        }
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
    <title>monch profile</title>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,900&display=swap" rel="stylesheet">

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
                        if (i==0){
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
                        var postid;
                        if (i==0){
                            posts=post[0].split("\n");
                            postid=posts[1]
                            hiddenlike.value=postid;
                        }else{
                            postid=post[0];
                            hiddenlike.value=postid;  
                        }
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
            xmlhttp.open("GET", "ajax/load-posts-other.php?user_id=<?php echo $_GET['user_id'];?>&friend=<?php echo $_GET['friend'];?>", true);
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
                        if (i==0){
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
                        var postid;
                        if (i==0){
                            posts=post[0].split("\n");
                            postid=posts[1]
                            hiddenlike.value=postid;
                        }else{
                            postid=post[0];
                            hiddenlike.value=postid;  
                        }
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
            xmlhttp.open("GET", "ajax/refresh-posts-other.php?user_id=<?php echo $_GET['user_id'];?>&friend=<?php echo $_GET['friend'];?>", true);
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

<body class="main-container" onload=loadposts()>
<div class="innerwrapper">

    <div class="header">
        <div class="menu_welcomePage">
            <ul>
                <li><a class="navlink" href="./messages.php?user_id=<?php echo $_GET['user_id'];?>">messages</a> </li> 
                <li><a class="navlink" href="./profile.php?user_id=<?php echo $_GET['user_id'];?>">profile</a> </li>         
                <li><a class="navlink" href="./index.php">logout</a> </li>
                <li><form method="post"><input type="text" name="search" placeholder="find a user"></form></li>
            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./feed.php?user_id=<?php echo $_GET['user_id']; ?>">monch</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <div class="message">
    
    <?php if($message!="") { 
        echo $message; 
        
        } ?> 
    </div> 
    <h1 class="welcome-page-title"><?php echo $row['username'];?></h1>

    <br><br>
    <?php
    if ($row['user_image']){
     echo '<img class="profilePicture" src="'. $row['user_image'] .'"/>';
    }else{
     echo '<img class="profilePicture" src="public/user-default.jpg" alt="you"';
    }
    ?>    
    <br>
    <?php
    $user = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'");
    $userInfo = mysqli_fetch_array($user);
    $following=$userInfo['following'];
    $followarray=explode(",", $following); 
    $counts = array_count_values($followarray);
    $count=$counts[$_GET['friend']];
    if (!in_array($_GET['friend'], $followarray) || $count % 2 == 0){
        echo '<form method="post" action=""><input type="submit" class="selectButtonNarrow" name="follow" value="follow"></form><br>';
    }else{
        echo '<form method="post" action=""><input type="submit" class="selectButtonWhite" name="unfollow" value="unfollow"><br>';
        echo '<input type="submit" class="selectButtonNarrow" name="message" value="message"></form><br>';
    }
    ?>
    <hr class='navbar'><br><br>


    <div class="cont" id="cont">
    </div>

</div>
</body>

</html>
