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
            echo "<b style='color:red;'>You are blocked</b>";
        }
        else{
            $blockbtnstatus = "select * from blockeduser where blockedby = $sid and blocked = $rid";
            $blockbtnres = mysqli_query($con, $blockbtnstatus);
            if($blockbtnres){
                if(mysqli_num_rows($blockbtnres) > 0){
                    echo "<b style='color:red;'>You blocked this user</b>";
                }
                else{
                    $sql = "select * from user where userid = $rid";
                    $res = mysqli_query($con, $sql);
                    if(mysqli_num_rows($res) > 0){
                        $chat = mysqli_fetch_assoc($res);
        
                        $statussql = "select * from userstatus where mainuser = $sid and otheruser = $rid";
                        $statusresult = mysqli_query($con,$statussql);
        
                        if(mysqli_num_rows($statusresult) > 0){
                            $row = mysqli_fetch_assoc($statusresult);
                            if($row['status'] != "null"){
                                echo "<b style='color:#3aff54;'>".$row['status']."</b>";
                            }
                            else{
                                echo $chat['status'];
                            }
                        }
                        else{
                            echo $chat['status'];
                        }
                    }
                }
            }
        }
    }
}
?>