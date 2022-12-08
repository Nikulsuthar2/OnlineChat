<?php
session_start();
include '../db.php';

if(isset($_POST['sendid']) && isset($_POST['receiveid'])){
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];


    $clearsender = "update message set senderclear = 1 where sender_id = $sid and receiver_id = $rid";
    $clearreceiver = "update message set receiverclear = 1 where receiver_id = $sid and sender_id = $rid";

    $res1 = mysqli_query($con, $clearsender);
    $res2 = mysqli_query($con, $clearreceiver);
    
    if($res1 && $res2){
        $sql = "delete from message where ((sender_id = $sid and receiver_id = $rid) or (sender_id = $rid and receiver_id = $sid)) and senderclear = 1 and receiverclear = 1";
        $res = mysqli_query($con, $sql);
        if($res){
            echo "success";
        }
    }
}
?>