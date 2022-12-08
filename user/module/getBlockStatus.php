<?php
session_start();
include '../db.php';

if(isset($_POST['sendid']) && isset($_POST['receiveid'])){
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    

    $blockbtnstatus = "select * from blockeduser where blockedby = $rid and blocked = $sid";
    $blockbtnres = mysqli_query($con, $blockbtnstatus);
    if($blockbtnres){
        if(mysqli_num_rows($blockbtnres) > 0){
            echo "block";
        }
        else{
            $blockbtnstatus = "select * from blockeduser where blockedby = $sid and blocked = $rid";
            $blockbtnres = mysqli_query($con, $blockbtnstatus);
            if($blockbtnres){
                if(mysqli_num_rows($blockbtnres) > 0){
                    echo "block";
                }
                else{
                    echo "noblock";
                }
            }
            else{
                echo "noblock";
            }
        }
    }
    else{
        echo "noblock";
    }

}
?>