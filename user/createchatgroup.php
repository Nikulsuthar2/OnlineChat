
<?php 
session_start();
include 'db.php';

if(isset($_SESSION["uid"])){
    $gauid = $_SESSION["uid"];
    $sql = "select * from user where userid = $gauid";
    $res = mysqli_query($con, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0)
            $gadata = mysqli_fetch_assoc($res);
    }
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
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/userhome.css">
    <link rel="stylesheet" href="../CSS/usersearch.css">
    <link rel="stylesheet" href="../CSS/group.css">
    <title>Create a Chat Group</title>
</head>
<body>
    <div class="main-container">
    <div class="chataccbox">
        <div class="groupheader">
            <a class="backbtn" href="userhome.php">&#11013</a>
			<input id="txtgroup" type="text" class="inputbox txtgroup" name="gname" placeholder="Enter group name" required />
            <input type="button" id="creategroupbtn" value="Create">
        </div>
        <hr>
        <div class="participent-container">
            <h3 style="margin-top: 5px;">Participants</h3>
            <div class="adminaccountchip">
                <div class='accdtlbox'>
                    <img class='profileimg' src='../<?php echo $gadata["image"]?>' width='40px' height='40px'>
                    <div class='accnamebox'>
                        <label class='accname'><?php echo $gadata["name"]?></label>
                    </div>
                </div>
                <label class="adminlebel">Group Admin</label>
            </div>
            <div id="participent-list">

            </div>
        </div>
    </div>
    <div class="add-user-box">
        <div class="groupheader">
            <input id="sbUser" class="searchbox txtgroup" type="search" name="usearch" placeholder="Enter name or email">
        </div>
        <hr>
        <div id="user-list" class="users-container">

        </div>
    </div>
    </div>
    <script>
        var participents = new Array();
        var searchbox = document.getElementById("sbUser");
        var groupname = document.getElementById("txtgroup");
        var creategroupbtn = document.getElementById("creategroupbtn");
        var chatbody = document.getElementById('user-list');
        var participentlist = document.getElementById('participent-list');
        var totalparicipant = 0;
        creategroupbtn.disabled = true;

        creategroupbtn.onclick = (e) => {
            if(participents.length > 1 && groupname.value != ""){
                var uidarraystring = ""
                participents.forEach((uid) => {
                    uidarraystring += uid+","
                });
                uidarraystring = uidarraystring.substring(0,uidarraystring.length-1);
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "module/createGroup.php" , true);
                xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
                xhr.onload = () =>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            
                            alert(data);
                            window.location.href = "userhome.php";
                        }
                    }
                }
                xhr.send("gname="+groupname.value.trim()+"&uids="+uidarraystring);
            }
        }

        function adduser(uid){
            if(!participents.includes(uid)){
                participents.push(uid);
                totalparicipant++;
                checkCreateButton()
                if(participents.length > 0){
                    var uidarraystring = ""
                    participents.forEach((uid) => {
                        uidarraystring += uid+","
                    });
                    uidarraystring = uidarraystring.substring(0,uidarraystring.length-1);
                    searchuser(uidarraystring);
                    getParticipents(uidarraystring);
                }
            }
        }
        function removeuser(uid){
            if(participents.includes(uid)){
                participents.splice(participents.indexOf(uid),1);
                totalparicipant--;
                checkCreateButton()
                if(participents.length > 0){
                    var uidarraystring = ""
                    participents.forEach((uid) => {
                        uidarraystring += uid+","
                    });
                    uidarraystring = uidarraystring.substring(0,uidarraystring.length-1);
                    searchuser(uidarraystring);
                    getParticipents(uidarraystring);
                }
                else{
                    getParticipents("");
                    searchuser("none");
                }
            }
        }

        function checkCreateButton(){
            if(participents.length > 1 && groupname.value != ""){
                creategroupbtn.disabled = false;
            }
            else{
                creategroupbtn.disabled = true;
            }
        }
        
        groupname.onkeyup = (e) =>{
            checkCreateButton();
        }

        searchbox.onkeyup = (e) =>{
            if(searchbox.value == ""){
                chatbody.innerHTML = "";
            }
            else{
                if(participents.length > 0){
                    var uidarraystring = ""
                    participents.forEach((uid) => {
                        uidarraystring += uid+","
                    });
                    uidarraystring = uidarraystring.substring(0,uidarraystring.length-1);
                    searchuser(uidarraystring)
                }
                else{
                    searchuser("none")
                }
                
                
            }
        }

        function searchuser(included){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/getUserForGroup.php" , true);
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
            xhr.send("search="+searchbox.value.trim()+"&included="+included);
        }

        function getParticipents(uids){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "module/getParticipents.php" , true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
                        participentlist.innerHTML = data;
                    }
                }
            }
            xhr.send("uids="+uids);
        }
    </script>
</body>
</html>