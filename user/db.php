<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "onlinechat";

$con = mysqli_connect($host,$user,$pass,$db);

if(!$con){
    die("connection failed");
}
?>