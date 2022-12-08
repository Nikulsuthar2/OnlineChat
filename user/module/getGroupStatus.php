<?php
session_start();
include '../db.php';

if(isset($_POST['gid'])){
    $gid = $_POST['gid'];
    
    $statussql = "select * from chatgroup where groupid = $gid";
    $statusresult = mysqli_query($con,$statussql);

    if($statusresult){
        if(mysqli_num_rows($statusresult) > 0){
            $row = mysqli_fetch_assoc($statusresult);
            if($row['status'] != ""){
                echo "<b style='color:#3aff54;'>".$row['status']."</b>";
            }
            else{
                echo "";
            }   
        }
    }
}
?>