<?php
session_start();
include 'db.php';

if($_SESSION["uid"]){
    $uid = $_SESSION["uid"];
    $sql = "select * from user where userid = $uid";
    $res = mysqli_query($con, $sql);
    if($res){
        $data = mysqli_fetch_assoc($res);
    }
}
else
{
    header("location: userlogin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - <?php echo $data['name'];?></title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/usersearch.css">
</head>
<body>
    <div class="chataccbox">
    <div style="display:flex; align-items:center; gap: 10px">
            <a class="backbtn" href="userhome.php">&#11013</a>
			<h1>Search</h1>
		</div>
        <div class="searchbtncontainer">
            <input id="sbUser" class="searchbox" type="search" name="usearch" placeholder="Enter name or email">
            <a class="searchbtn" href="#">&#128269</a>
        </div>
        <hr>
        <div id="user-list" class="chataccbody">
            
        </div>
    </div>
    <script>
        var searchbox = document.getElementById("sbUser");
        var chatbody = document.getElementById('user-list');


        searchbox.onkeyup = (e) =>{
            if(searchbox.value == ""){
                chatbody.innerHTML = "";
            }
            else{
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "module/getUser.php" , true);
                xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
                xhr.onload = () =>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);
                            chatbody.innerHTML = data;
                        }
                    }
                }
                xhr.send("search="+searchbox.value.trim());
            }
        }
    </script>
</body>
</html>