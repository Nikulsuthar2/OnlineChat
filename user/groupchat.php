
<?php 
session_start();
include 'db.php';

if(isset($_SESSION["uid"]) && isset($_GET["gid"])){
    $gid = $_GET["gid"];
    $sql = "select * from chatgroup where groupid = $gid";
    $res = mysqli_query($con, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0)
            $gdata = mysqli_fetch_assoc($res);
    }

    $gauid = $_SESSION["uid"];
    $gadminsql = "select * from user where userid = $gdata[adminid]";
    $gadminres = mysqli_query($con, $gadminsql);
    if ($gadminres) {
        if (mysqli_num_rows($gadminres) > 0)
            $gadata = mysqli_fetch_assoc($gadminres);
    }

    $partisql = "select * from gparticipants where groupid = $gid";
    $partires = mysqli_query($con, $partisql);
    $totalparticepants = mysqli_num_rows($partires) + 1;


} else {
    header("location: userhome.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/userchat.css">
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/usersearch.css">
    <link rel="stylesheet" href="../CSS/group.css">
    
    <title>Group Chat</title>
</head>
<body>
    <div class="main-container">
    <div class="chataccbox">
        <div class="groupheader">
			<div class="accdtlbox">
                <a class="backbtn" href="userhome.php">&#11013</a>
                <div class='profileborder <?php if($_SESSION["uid"] == $gdata["adminid"]) echo "owngroup";?>'>
                    <img id="profileimg" class="groupprofileimg" src="../<?php echo $gdata["image"]; ?>" width="30px" height="30px">
                </div>
                <div class="accnamebox">
                    <label class="accname"><?php echo $gdata['groupname']?> &#128101</label>
                    <p><label id="accstatus" class="accstatus"></label><?php echo $totalparticepants;?> Participants</p>
                </div>
            </div>
        </div>
        <div id="chat-container" class="chat-container" onload="chatonload()">
            
        </div>
        <div class="chat-send-box">
            <input hidden type="text" id="senderid" value="<?php echo $_SESSION["uid"];?>">
            <input hidden type="text" id="groupid" value="<?php echo $gid;?>">
            <input id="txtMsg" type="text" name="msgtext" placeholder="write your message" spellcheck="false">
            <input id="btnSend" type="button" value="send">
        </div>
    </div>
    <div class="Participant-user-box">
        <div class="groupheader">
            <h2>Participants</h2>
            
        </div>
        
        <hr>
        <div id="user-list" class="users-container">
            <div class="adminaccountchip">
                <div class='accdtlbox' 
                <?php 
                if($gadata["userid"] != $_SESSION["uid"]){
                    echo "onClick='openChatUser($gadata[userid])'";
                }
                else{
                    $gadata["name"] = $gadata["name"] . " (You)";
                }
                ?>
                >
                    <img class='profileimg' src='../<?php echo $gadata["image"]?>' width='30px' height='30px'>
                    <div class='accnamebox'>
                        <label class='accname'><?php echo $gadata["name"]?></label>
                    </div>
                </div>
                <label style="font-size: 12px;" class="adminlebel">Group Admin</label>
            </div>
            <?php 
                if($partires){
                    if(mysqli_num_rows($partires) > 0){
                        while($participantdata = mysqli_fetch_assoc($partires)){
                            $usersql = "select * from user where userid = $participantdata[participantid]";
                            $userres = mysqli_query($con, $usersql);
                            if($userres){
                                if(mysqli_num_rows($userres) > 0){
                                    $udata=mysqli_fetch_array($userres);
                                    echo "<div class='adminaccountchip' ";
                                    if($udata["userid"] != $_SESSION["uid"]){
                                        echo "onClick='openChatUser($udata[userid])'";
                                    }
                                    else{
                                        $udata["name"] = $udata["name"] . " (You)";
                                    }
                                    echo ">
                                        <div class='accdtlbox'>
                                            <img class='profileimg' src='../$udata[image]' width='30px' height='30px'>
                                            <div class='accnamebox'>
                                                <label class='accname'>$udata[name]</label>
                                            </div>
                                        </div>
                                        
                                    </div>";
                                }
                            }
                            
                        }
                    }
                }
            ?>
        </div>
    </div>
    </div>
    <script>
        var owntypingstatus = false;
        var btnSend = document.getElementById("btnSend");
        var txtMsg = document.getElementById("txtMsg");
        var senderid = document.getElementById("senderid");
        var groupid = document.getElementById("groupid");
        var groupstatus = document.getElementById("accstatus");
        var chatcontainer = document.getElementById("chat-container");

        setTimeout(() => {
            chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
        }, 1500);

        btnSend.onclick = (e) => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/sendGroupMsg.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        txtMsg.value = "";
                        chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
                    }
                }
            }
            xhr.send("msg="+txtMsg.value.trim()+"&sendid="+senderid.value+"&groupid="+groupid.value);
            txtMsg.focus();
        }

        txtMsg.onkeypress = () => {
            owntypingstatus = true;
            let xhr3 = new XMLHttpRequest();
            xhr3.open("POST", "module/sendGroupStatus.php" , true);
            xhr3.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            
            xhr3.send("gid="+groupid.value+"&senderid="+senderid.value+"&status=typing...");

            setTimeout(() => {
                let xhr3 = new XMLHttpRequest();
                xhr3.open("POST", "module/sendGroupStatus.php" , true);
                xhr3.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                
                xhr3.send("gid="+groupid.value+"&senderid="+senderid.value+"&status=null");
                owntypingstatus = false;
            },2000);

            
        }

        var previousMsg = "";
        setInterval(() =>{
            let xhr1 = new XMLHttpRequest();
            xhr1.open("POST", "module/getGroupMsg.php" , true);
            xhr1.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr1.onload = () =>{
                if(xhr1.readyState === XMLHttpRequest.DONE){
                    if(xhr1.status === 200){
                        if(xhr1.response != previousMsg){
                            let data = xhr1.response;
                            chatcontainer.innerHTML = data;
                            previousMsg = xhr1.response;
                            chatcontainer.scroll({top: chatcontainer.scrollHeight,behavior: "smooth"});
                        }
                    }
                }
            }
            xhr1.send("senderid="+senderid.value+"&groupid="+groupid.value);

            let xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "module/getGroupStatus.php" , true);
            xhr2.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr2.onload = () =>{
                if(xhr2.readyState === XMLHttpRequest.DONE){
                    if(xhr2.status === 200){
                        if(xhr2.response == ""){
                            groupstatus.innerHTML = xhr2.response;
                        }
                        else{
                            if(owntypingstatus == false){
                                groupstatus.innerHTML = xhr2.response + " . ";
                            }
                            else{
                                groupstatus.innerHTML = "";
                            }
                            
                        }
                        
                    }
                }
            }
            xhr2.send("gid="+groupid.value);
        },500);

        function openChatUser(userid){
            window.location.href = 'userchat.php?uid='+userid;
        }
    </script>
</body>
</html>