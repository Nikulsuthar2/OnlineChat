<?php
session_start();
include 'db.php';

$totalrec = 0;
$headtitle = "Users";
if($_SESSION["aid"]){
    $aid = $_SESSION["aid"];
    $sql = "select * from admin where adminid = $aid";
    $res = mysqli_query($con, $sql);
    if($res){
        $data = mysqli_fetch_assoc($res);
    }

    if(isset($_GET['user'])){
        $headtitle = "Users";
        $user = $_GET['user'];
        if($user == "Active")
            $usql = "select * from user where status = 'online'";
        else if($user == "Inactive")
            $usql = "select * from user where status = 'offline'";
        else
            $usql = "select * from user";         
    }
    elseif(isset($_GET['blockedby'])){
        $headtitle = "<a style='text-decoration:none;' class='backbtn' 
        href='userlist.php'>&#11013</a> Blocked by ".$_GET['name'];
        $usql = "select * from user a, blockeduser b where a.userid = b.blocked and b.blockedby = $_GET[blockedby]";
    }
    else
        $usql = "select * from user"; 
    $ures = mysqli_query($con,$usql);  
    if($ures){
        $totalrec = mysqli_num_rows($ures);
    } 
}
else
{
    header("location: adminlogin.php");
}
?>
<html>
<head>
    <title>User list</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <?php include 'adminnavbar.php';?>
    <div class="admin-main-body">
        <div class="header">
            <h1><?php echo $headtitle;?></h1>
        </div>
        <div class="user-list">
            <div class="list-topbar">
                <p>Users List</p>
                <div>
                    <a class="adminbtn" href="userlist.php">Total Users</a>
                    <a class="adminbtn" href="userlist.php?user=Active">Active Users</a>
                    <a class="adminbtn" href="userlist.php?user=Inactive">Inactive Users</a>
                </div>
                <p>Total : <?php echo $totalrec;?></p>
            </div>
            <div class="list-table">
                <table>
                    <tr>
                        <th width="5%">S.No.</th>
                        <th width="15%">Profile Image</th>
                        <th width="5%">User ID</th>
                        <th width="20%">Name</th>
                        <th width="30%">Email Address</th>
                        <th width="10%">Account Status</th>
                        <th width="10%">Total Blocked Users</th>
                        <th width="10%">Action</th>
                    </tr>
                    <?php
                    $count = 0;
                    if($ures){
                        while($udata = mysqli_fetch_assoc($ures)){
                            $totalblocked = 0;
                            $busql = "select * from blockeduser where blockedby = $udata[userid]";
                            $bures = mysqli_query($con,$busql);
                            if($bures){
                                $totalblocked = mysqli_num_rows($bures);
                            }

                            $count++;
                            if($udata["status"] == "online"){
                                $ustatus = "<div class='onbadge'>Active</div>";
                            }
                            else{
                                $ustatus = "<div class='offbadge'>InActive</div>";
                            }
                            echo "<tr>
                                <td>$count</td>
                                <td><img class='profileimg' src='../$udata[image]' width='40px' height='40px' draggable='false'></td>
                                <td>$udata[userid]</td>
                                <td>$udata[name]</td>
                                <td>$udata[email]</td>
                                <td>$ustatus</td>
                                <td>";
                            if($totalblocked > 0)  echo "<a class='blockcountbtn' href='?blockedby=$udata[userid]&name=$udata[name]'>$totalblocked</a>";
                            else echo $totalblocked;
                            echo "</td>
                                <td><input class='removebtn' type='button' value='remove' onclick='userDelete(\"delid=$udata[userid]\")'></td>
                            </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        function userDelete(delUrl){
            if(confirm("Are you sure you want to delete")){
                let xhr = new XMLHttpRequest();
                xhr.open('POST','deleteUser.php',true);
                xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            if(xhr.response == "sucess"){
                                alert("User Deleted Sucessfully");
                                document.location = 'userlist.php';
                            }
                            else{
                                alert("User not Deleted" + xhr.response);
                            }
                        }
                    }
                }
                xhr.send(delUrl);
            }
        }
    </script>
</body>
</html>