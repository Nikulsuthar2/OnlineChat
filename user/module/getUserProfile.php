<?php
session_start();
include '../db.php';

if(isset($_POST['userid'])){
    $rid = $_POST['userid'];
    $sid = $_POST['senderid'];

    $blockbtnstatus = "select * from blockeduser where blockedby = $rid and blocked = $sid";
    $blockbtnres = mysqli_query($con, $blockbtnstatus);
    if($blockbtnres){
        if(mysqli_num_rows($blockbtnres) > 0){
            echo "image/profileimg/profiledef.png";
        }
        else{
            $sql = "select * from user where userid = $rid";
            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0){
                $chat = mysqli_fetch_assoc($res);
                echo $chat['image'];
            }
        }
    }
}
?>