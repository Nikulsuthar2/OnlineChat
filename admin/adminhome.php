<?php
session_start();
include 'db.php';

if($_SESSION["aid"]){
    $aid = $_SESSION["aid"];
    $sql = "select * from admin where adminid = $aid";
    $res = mysqli_query($con, $sql);
    if($res){
        $data = mysqli_fetch_assoc($res);
    }
}
else
{
    header("location: adminlogin.php");
}
?>
<html>
<head>
    <title>Online Chat Admin</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <?php include 'adminnavbar.php';?>
    <div class="admin-main-body">
        <div id="info-list">
            
        </div>
    </div>
    <script>
        var infolist = document.getElementById("info-list");
        var info = "";

        setInterval(() => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "getInfo.php" , true);
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        if(info != xhr.response){
                            info = xhr.response;
                            infolist.innerHTML = info;
                        }
                    }
                }
            }
            xhr.send();
        },500);
    </script>
</body>
</html>