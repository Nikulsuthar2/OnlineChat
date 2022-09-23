<?php
include 'db.php';
$sql = "select * from user";
$res = mysqli_query($con,$sql);
if($res){
    $totaluser =  mysqli_num_rows($res);
    echo "<a class='info-card' href='userlist.php'>
        <label class='info-title'>Total Users</label>
        <label class='info-value'>$totaluser</label>
    </a>";
}

$sql = "select * from user where status='online'";
$res = mysqli_query($con,$sql);
if($res){
    $totalAuser =  mysqli_num_rows($res);
    echo "<a class='info-card' href='userlist.php?user=Active'>
        <label>Total Active Users</label>
        <label class='info-value'>$totalAuser</label>
    </a>";
}

$sql = "select * from user where status='offline'";
$res = mysqli_query($con,$sql);
if($res){
    $totalIAuser =  mysqli_num_rows($res);
    echo "<a class='info-card' href='userlist.php?user=Inactive'>
        <label>Total InActive Users</label>
        <label class='info-value'>$totalIAuser</label>
    </a>";
}

$sql = "select min(msgid), least(sender_id, receiver_id), greatest(sender_id, receiver_id) from message group by least(sender_id, receiver_id), greatest(sender_id, receiver_id)";
$res = mysqli_query($con,$sql);
if($res){
    $totalcmsg =  mysqli_num_rows($res);
    echo "<a class='info-card' href='userchatreport.php'>
        <label>Total Chats</label>
        <label class='info-value'>$totalcmsg</label>
    </a>";
}

$sql = "select * from message";
$res = mysqli_query($con,$sql);
if($res){
    $totalmsg =  mysqli_num_rows($res);
    echo "<a class='info-card' href='userchatreport.php'>
        <label>Total Chat Messages</label>
        <label class='info-value'>$totalmsg</label>
    </a>";
}
?>