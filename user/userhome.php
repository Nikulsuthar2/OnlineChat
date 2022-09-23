<?php
session_start();
include 'db.php';

if($_SESSION["uid"]){
    $uid = $_SESSION["uid"];
    $sql = "select * from user where userid = $uid";
    $res = mysqli_query($con, $sql);
    if($res){
        if(mysqli_num_rows($res) > 0)
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
    <title>Home - <?php if(isset($data['name'])) echo $data['name'];?></title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
</head>
<body>
    <div class="chataccbox">
        <div class="header">
            <div class="accdtlbox">
                <input hidden type="text" id="userid" value="<?php echo $_SESSION["uid"];?>">
                <img class="profileimg" src="../<?php if(isset($data['image'])) echo $data['image']; else echo "image/profileimg/profiledef.png";?>" width="50px" height="50px">
                <div class="accnamebox">
                    <label class="accname"><?php if(isset($data['name'])) echo $data['name']; else echo "Unknown User";?></label>
                    <label class="accstatus"><?php if(isset($data['status'])) echo $data['status']?></label>
                </div>
            </div>
			<div>
				<a class="editprobtn" href="editProfile.php">Edit Profile</a>
				<a class="logoutbtn" href="logout.php?uid=<?php echo $uid;?>">Logout</a>
			</div>
        </div>
        <hr>
        <div class="searchbtncontainer">
            <label>Select an user to start chat</label>
            <a class="searchbtn" href="usersearch.php">&#128269</a>
        </div>
        <div id="user-list" class="chataccbody">
            
        </div>
    </div>
    <script>
        var previousdata;
        var count = 0;
        var userid = document.getElementById('userid');
        var chatbody = document.getElementById('user-list');
        setInterval(()=>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/getChatUser.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        if(previousdata != data){
                            console.log("not equal");
                            chatbody.innerHTML = data;
                            previousdata = data;
                        }
                    }
                }
            }
            xhr.send("curruid="+userid.value);
        }, 500);
    </script>
</body>
</html>