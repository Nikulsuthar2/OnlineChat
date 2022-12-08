<?php
session_start();
include '../db.php';
date_default_timezone_set("Asia/Kolkata");
if(isset($_POST['msg']) && isset($_POST['groupid'])){
    $msg = $_POST['msg'];
    $sid = $_POST['sendid'];
    $gid = $_POST['groupid'];
    $date = date("Y-m-d");
    $time = date("h:i A");
    if($msg != ""){
        $sql = "insert into groupmessage(groupid,senderid,message,date,time) 
            values($gid,$sid,'$msg','$date','$time')";
        $res = mysqli_query($con, $sql);
        if($res){
            echo "success";
        }
    }
}
?>