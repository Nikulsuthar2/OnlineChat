<?php
session_start();
include '../db.php';

if(isset($_POST['gid'])){
    $gid = $_POST['gid'];
    $sid = $_POST['senderid'];
    $status = $_POST['status'];
    

    if($status == "typing..."){
        $namesql = "select name from user where userid = $sid";
        $nameres = mysqli_query($con,$namesql);
        if($nameres){
            if(mysqli_num_rows($nameres) > 0){
                $udata = mysqli_fetch_assoc($nameres);
                $updatedata = "update chatgroup set status = '$udata[name] is $status' where groupid = $gid";
                $updateresult = mysqli_query($con,$updatedata);
                if($updateresult){
                    echo "status updated";
                }
            }
        } 
        
    }
    else{
        $updatedata = "update chatgroup set status = NULL where groupid = $gid";
        $updateresult = mysqli_query($con,$updatedata);
        if($updateresult){
            echo "status set null updated";
        }
    }
}
?>