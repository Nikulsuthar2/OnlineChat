<?php
session_start();
include '../db.php';

$output = "";
if(isset($_POST["uids"])){
    if($_POST["uids"] != ""){
        $notallowed = explode(",",$_POST['uids']);
    
        foreach($notallowed as $id){
            $sql = "select * from user where userid = $id";
        
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res) > 0){
                $data = mysqli_fetch_assoc($res);
                $output .="<div class='adminaccountchip'>
                    <div class='accdtlbox'>
                        <img class='profileimg' src='../$data[image]' width='40px' height='40px'>
                        <div class='accnamebox'>
                            <label class='accname'>$data[name]</label>
                        </div>
                    </div>
                    <input type='button' class='userdelbtn' onClick='removeuser($data[userid])'  value= 'Remove'>
                </div>";
            }
        }
        echo $output;
    }
}

?>