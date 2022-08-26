<?php
session_start();
include '../db.php';

if(isset($_POST['userid'])){
    $rid = $_POST['userid'];
    
    $sql = "select * from user where userid = $rid";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0){
        $chat = mysqli_fetch_assoc($res);
        echo $chat['status'];
    }
}
?>