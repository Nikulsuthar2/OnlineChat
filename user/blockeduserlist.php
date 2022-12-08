<?php
session_start();
include 'db.php';

if($_SESSION["uid"]){
    $uid = $_SESSION["uid"];
    $sql = "select * from blockeduser where blockedby = $uid";
    $res = mysqli_query($con, $sql);
}
else
{
    header("location: userlogin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blocked Users</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/usersearch.css">
</head>
<body>
    <div class="chataccbox">
    <div style="display:flex; align-items:center; gap: 10px">
            <a class="backbtn" href="userhome.php">&#11013</a>
			<h1>Blocked User</h1>
		</div>
        <hr>
        <div id="user-list" class="chataccbody">
            <?php
            if($res){
                if(mysqli_num_rows($res) > 0){
                    while($data1 = mysqli_fetch_assoc($res)){
                        $sql1 = "select * from user where userid = $data1[blocked]";
                        $res1 = mysqli_query($con,$sql1);
                        if($res1){
                            $data = mysqli_fetch_assoc($res1);
                            echo "<a href='userchat.php?uid=$data[userid]' class='chataccbtn'>
                                <div class='accdtlbox'>
                                    <img class='profileimg' src='../image/profileimg/profiledef.png' width='40px' height='40px'>
                                    <div class='accnamebox'>
                                        <label class='accname'>$data[name]</label>
                                        <label class='acclastmsg'></label>
                                    </div>
                                </div>
                            </a>";
                        }
                    }
                }
                else{
                    echo "<div style='height:80px;display:flex;justify-content:center;align-items:center;'>
                    <b>No User Blocked &#128683</b></div>";
                }
            }
            ?>
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