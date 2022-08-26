<?php
session_start();
include 'db.php';

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
                <img class="profileimg" src="../<?php echo $data['image']?>" width="30px" height="30px">
                <div class="accnamebox">
                    <label class="accname"><?php echo $data['name']?></label>
                    <label id="accstatus" class="accstatus"><?php echo $data['status']?></label>
                </div>
            </div>
        </div>
        <div id="chat-container" class="chat-container" onload="chatonload()">
            
        </div>
        <div class="chat-send-box">
            <input hidden type="text" id="senderid" value="<?php echo $_SESSION["uid"];?>">
            <input hidden type="text" id="receiverid" value="<?php echo $uid;?>">
            <input id="txtMsg" type="text" name="msgtext" placeholder="write your message" spellcheck="false">
            <input id="btnSend" type="button" value="send">
        </div>
    </div>
    <script>
        var btnsend = document.getElementById("btnSend");
        var txtmsg = document.getElementById("txtMsg");
        var senderid = document.getElementById("senderid");
        var receiverid = document.getElementById("receiverid");
        var chatcontainer = document.getElementById("chat-container");
        var lblstatus = document.getElementById("accstatus");

        setTimeout(() => {
            chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
        }, 1500);

        btnsend.onclick = () =>{
			//alert("msg="+txtmsg.value+"&sendid="+senderid.value+"&receiveid="+receiverid.value);
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
            xhr.send("msg="+txtmsg.value+"&sendid="+senderid.value+"&receiveid="+receiverid.value);
        }

        setInterval(() =>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/getMsg.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        chatcontainer.innerHTML = data;
                    }
                }
            }
            xhr.send("sendid="+senderid.value+"&receiveid="+receiverid.value);

            let xhr1 = new XMLHttpRequest();
            xhr1.open("POST", "module/getUserStatus.php" , true);
            xhr1.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr1.onload = () =>{
                if(xhr1.readyState === XMLHttpRequest.DONE){
                    if(xhr1.status === 200){
                        let status = xhr1.response;
                        lblstatus.innerHTML = status;
                    }
                }
            }
            xhr1.send("userid="+receiverid.value);
			
			let xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "module/updateMsgStatus.php" , true);
            xhr2.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
			xhr2.onload = () =>{
                if(xhr2.readyState === XMLHttpRequest.DONE){
                    if(xhr2.status === 200){
                        console.log(xhr2.response);
                    }
                }
            }
            xhr2.send("msgstatus=seen&rid="+receiverid.value+"&sid="+senderid.value);
        },500);
    </script>
</body>
</html>