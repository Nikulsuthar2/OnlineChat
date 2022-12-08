<?php
include '../db.php';

if(isset($_POST["blockedby"]) && isset($_POST["blocked"]) && isset($_POST["action"])){
    $blockedby = $_POST["blockedby"];
    $blocked = $_POST["blocked"];

    if($_POST["action"] == "Block"){
        $sql = "insert into blockeduser(blockedby,blocked) values($blockedby,$blocked)";
        $result = mysqli_query($con, $sql);

        if($result){
            echo "user blocked";
        }
    }
    else{
        $sql = "delete from blockeduser where blockedby = $blockedby and blocked = $blocked";
        $result = mysqli_query($con, $sql);

        if($result){
            echo "user unblocked";
        }
    }
}
?>