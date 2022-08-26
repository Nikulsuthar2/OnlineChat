<?php
session_start();
include 'db.php';


if(isset($_GET['uid'])){
    $sql = "update user set status = 'offline' where userid = $_GET[uid]";
    $res = mysqli_query($con, $sql);
}

unset($_SESSION['uid']);
session_destroy();

header("location: userlogin.php");
?>