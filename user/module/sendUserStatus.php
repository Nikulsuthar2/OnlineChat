<?php
session_start();
include '../db.php';

if(isset($_POST['main'])){
    $main = $_POST['main'];
    $other = $_POST['other'];
    $status = $_POST['status'];
    
    $checkdata = "select * from userstatus where mainuser = $main and otheruser = $other";
    $checkresult = mysqli_query($con, $checkdata);
    if(mysqli_num_rows($checkresult) > 0){
        $updatedata = "update userstatus set status = '$status' where mainuser = $main and otheruser = $other";
        $updateresult = mysqli_query($con,$updatedata);
        if($updateresult){
            echo "status updated";
        }
    }
    else{
        $insertdata = "insert into userstatus(mainuser,otheruser,status) values($main,$other,'$status')";
        $inserresult = mysqli_query($con,$insertdata);
        if($updateresult){
            echo "status created";
        }
    }
}
?>