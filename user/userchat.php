<?php
session_start();
include 'db.php';

$btnblocked = true;
if($_SESSION["uid"]){
    $uid = $_GET['uid'];
	if($uid == $_SESSION["uid"])
		header("location: userhome.php");
    $sql = "select * from user where userid = $uid";
    $res = mysqli_query($con, $sql);
    if($res){
        $data = mysqli_fetch_assoc($res);
    }

    $updateseensql = "update message set msg_status = 'seen' where sender_id = $uid and receiver_id = $_SESSION[uid] and msg_status = 'unseen'";
    $updateres = mysqli_query($con,$updateseensql);

    $blockbtnstatus = "select * from blockeduser where blockedby = $_SESSION[uid] and blocked = $uid";
    $blockbtnres = mysqli_query($con, $blockbtnstatus);
    if($blockbtnres){
        if(mysqli_num_rows($blockbtnres) > 0)
            $btnblocked = false;
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
    <title>Chat <?php echo $_SESSION['uname']." to ".$data['name'];?></title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/userchat.css">
    <link rel="stylesheet" href="../CSS/usersearch.css">
</head>
<body>
    <div class="chataccbox">
        <div class="header">
            <div class="accdtlbox">
                <a class="backbtn" href="userhome.php">&#11013</a>
                <img id="profileimg" class="profileimg" src="../image/profileimg/profiledef.png" width="30px" height="30px">
                <div class="accnamebox">
                    <label class="accname"><?php echo $data['name']?></label>
                    <label id="accstatus" class="accstatus"><?php echo $data['status']?></label>
                </div>
            </div>
            <div>
                <input id="btnClearChat" class="clearbtn" type="button" value="Clear Chat">
                <?php 
                    if($btnblocked){
                        echo '<input id="btnBlock" class="blockbtn" type="button" value="Block">';
                    }
                    else{
                        echo '<input id="btnBlock" class="blockbtn" type="button" value="Unblock">';
                    }  
                ?>
				
			</div>
        </div>
        <div id="chat-container" class="chat-container" onload="chatonload()">
            
        </div>
        <div class="chat-send-box">
            <input hidden type="text" id="senderid" value="<?php echo $_SESSION["uid"];?>">
            <input hidden type="text" id="receiverid" value="<?php echo $uid;?>">
            <input id="txtMsg" type="text" name="msgtext" placeholder="write your message" spellcheck="false">
            <label class="imagesendbtn" id="btnFileSend" for="sendFile">File</label>
            <input hidden id="sendFile" type="File" >
            <input id="btnSend" type="button" value="send">
        </div>
    </div>
    <script>
        var btnsend = document.getElementById("btnSend");
        var filesend = document.getElementById("sendFile");
        var btnblock = document.getElementById("btnBlock");
        var btnClearChat = document.getElementById("btnClearChat");
        var txtmsg = document.getElementById("txtMsg");
        var senderid = document.getElementById("senderid");
        var receiverid = document.getElementById("receiverid");
        var chatcontainer = document.getElementById("chat-container");
        var profileimg = document.getElementById("profileimg");
        var lblstatus = document.getElementById("accstatus");

        setTimeout(() => {
            chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
        }, 1500);

        txtmsg.onkeypress = () => {
            let xhr1 = new XMLHttpRequest();
            xhr1.open("POST", "module/sendUserStatus.php" , true);
            xhr1.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr1.send("main="+receiverid.value+"&other="+senderid.value+"&status=Typing..");

            setTimeout(() => {
                let xhr8 = new XMLHttpRequest();
                xhr8.open("POST", "module/sendUserStatus.php" , true);
                xhr8.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
                xhr8.send("main="+receiverid.value+"&other="+senderid.value+"&status=null");
            },2000);
        }

        btnsend.onclick = () =>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/sendMsg.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        txtmsg.value = "";
                        chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
                    }
                }
            }
            xhr.send("msg="+txtmsg.value.trim()+"&sendid="+senderid.value+"&receiveid="+receiverid.value);
            txtmsg.focus();
        }

        filesend.onchange = (e) => {
            if(filesend.files.length > 0){
                var formData = new FormData();
                var files = filesend.files;
                formData.append('msg',txtmsg.value.trim());
                formData.append('sendid',senderid.value);
                formData.append('receiveid',receiverid.value);
                formData.append('myFile',files[0],files[0].name);

                let xhr9 = new XMLHttpRequest();
                xhr9.open("POST", "module/sendFileMsg.php" , true);
                
                xhr9.onload = () =>{
                if(xhr9.readyState === XMLHttpRequest.DONE){
                    if(xhr9.status === 200){
                        console.log(xhr9.response);
                        txtmsg.value = "";
                        filesend.files = [];
                        chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
                    }
                }
            }
                xhr9.send(formData);
            }
        }
        // btn image on click
        /*

            
        */
        btnblock.onclick = () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/blockUser.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        document.location.reload();
                    }
                }
            }
            xhr.send("blockedby="+senderid.value+"&blocked="+receiverid.value+"&action="+btnblock.value);
        }

        btnClearChat.onclick = () =>{
            if(confirm("Are you sure")){
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "module/clearChat.php" , true);
                xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
                xhr.onload = () =>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            console.log(xhr.response);
                        }
                    }
                }
                xhr.send("sendid="+senderid.value+"&receiveid="+receiverid.value);
                txtmsg.focus();
            }
        }

        var previousMsg = "";
        var previousimg = "";
        setInterval(() =>{
            let xhr1 = new XMLHttpRequest();
            xhr1.open("POST", "module/getUserStatus.php" , true);
            xhr1.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr1.onload = () =>{
                if(xhr1.readyState === XMLHttpRequest.DONE){
                    if(xhr1.status === 200){
                        let status = xhr1.response;
                        if(status != lblstatus.innerHTML){
                            lblstatus.innerHTML = status;
                            console.log(status);
                        }
                    }
                }
            }
            xhr1.send("userid="+receiverid.value+"&senderid="+senderid.value);

            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/getMsg.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        if(xhr.response != previousMsg){
                            let data = xhr.response;
                            chatcontainer.innerHTML = data;
                            previousMsg = xhr.response;
                            chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
                        }
                    }
                }
            }
            xhr.send("sendid="+senderid.value+"&receiveid="+receiverid.value);
			
			let xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "module/updateMsgStatus.php" , true);
            xhr2.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr2.send("msgstatus=seen&rid="+receiverid.value+"&sid="+senderid.value);

            let xhr3 = new XMLHttpRequest();
            xhr3.open("POST", "module/getUserProfile.php" , true);
            xhr3.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr3.onload = () =>{
                if(xhr3.readyState === XMLHttpRequest.DONE){
                    if(xhr3.status === 200){
                        if(xhr3.response != previousimg){
                            profileimg.src = "../"+xhr3.response;
                            previousimg = xhr3.response;
                        }
                    }
                }
            }
            xhr3.send("userid="+receiverid.value+"&senderid="+senderid.value);

            let xhr4 = new XMLHttpRequest();
            xhr4.open("POST", "module/getBlockStatus.php" , true);
            xhr4.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr4.onload = () =>{
                if(xhr4.readyState === XMLHttpRequest.DONE){
                    if(xhr4.status === 200){
                        if(xhr4.response == "block"){
                            btnsend.disabled = true;
                            txtmsg.disabled = true;
                        }
                        else{
                            btnsend.disabled = false;
                            txtmsg.disabled = false;
                        }
                    }
                }
            }
            xhr4.send("receiveid="+receiverid.value+"&sendid="+senderid.value);
        },500);

        function openImage(fileloc){
            window.location.href = "../"+fileloc.toString();
        }
    </script>
</body>
</html>