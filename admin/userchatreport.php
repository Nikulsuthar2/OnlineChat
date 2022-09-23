<?php
session_start();
include 'db.php';

$totalrec = 0;
if($_SESSION["aid"]){
    $aid = $_SESSION["aid"];
    $sql = "select * from admin where adminid = $aid";
    $res = mysqli_query($con, $sql);
    if($res){
        $data = mysqli_fetch_assoc($res);
    }

    
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
    <title>Users Chat Report</title>
    <link rel="stylesheet" href="../CSS/comman.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <?php include 'adminnavbar.php';?>
    <div class="admin-main-body">
        <div class="header">
            <h1>Users Chat Report</h1>
            <input type="button" onclick="printReport('user-list','User Chat Report :- <br>'+new Date(),'User Chat Report')" value="Print">
        </div>
        <div id="user-list" class="user-list">
            <div class="list-topbar">
                <p>Users chats details</p>
                <p>Total : <?php echo $totalrec;?></p>
            </div>
            <div class="list-table">
                <table>
                    <tr>
                        <th width="5%">S.No.</th>
                        <th width="15%">Name</th>
                        <th width="20%">Email Address</th>
                        <th width="10%">Account Status</th>
                        <th width="10%">Total Chats</th>
                        <th width="20%">Total Sent Messages</th>
                        <th width="20%">Total Received Messages</th>
                    </tr>
                    <?php
                    $count = 0;
                    if($ures){
                        while($udata = mysqli_fetch_assoc($ures)){
                            $count++;

                            $sentmsgsql = "select * from message where sender_id = $udata[userid]";
                            $sentres = mysqli_query($con,$sentmsgsql);
                            if($sentres)
                                $totalsentmsg = mysqli_num_rows($sentres);
                            $receivemsgq = "select * from message where receiver_id = $udata[userid]";
                            $receiveres = mysqli_query($con,$receivemsgq);
                            if($receiveres)
                                $totalreceivemsg = mysqli_num_rows($receiveres);
                            
                            $chatsql = "select distinct sender_id from message where receiver_id = $udata[userid]  
                            union select distinct receiver_id from message where sender_id = $udata[userid]";
                            
                            $totcres = mysqli_query($con, $chatsql);
                            if($totcres)
                                $totalchats = mysqli_num_rows($totcres);
                            
                            if($udata["status"] == "online"){
                                $ustatus = "<div class='onbadge'>$udata[status]</div>";
                            }
                            else{
                                $ustatus = "<div class='offbadge'>$udata[status]</div>";
                            }

                            echo "<tr>
                                <td>$count</td>
                                <td>$udata[name]</td>
                                <td>$udata[email]</td>
                                <td>$ustatus</td>
                                <td>$totalchats</td>
                                <td>$totalsentmsg</td>
                                <td>$totalreceivemsg</td>
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
        function printReport(id,title,pdfname){
            var control = document.getElementById(id).innerHTML;
            var a = window.open('','','height=900, width=900');
            a.document.write('<html><head><title>'+pdfname+'</title>');
            a.document.write('<link rel="stylesheet" href="../CSS/admin.css"></head><body><h2>'+title+'</h2>');
            a.document.write(control);
            a.document.write('</body></html>');
            a.document.close;
            a.print();
        }
    </script>
</body>
</html>