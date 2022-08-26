<?php
session_start();
include '../db.php';

if(isset($_POST['msg'])){
    $msg = $_POST['msg'];
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    $date = date("Y-m-d");
    $time = date("h:i A");
    if($msg != ""){
        $sql = "insert into message(sender_id,receiver_id,message,date,time) 
            values($sid,$rid,'$msg','$date','$time')";
        $res = mysqli_query($con, $sql);
        if($res){
            echo "success";
        }
    }
}
?>