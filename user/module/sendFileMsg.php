<?php
session_start();
include '../db.php';
date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d");
$time = date("h:i A");
$type = "Text";


if(isset($_POST['msg'])){
    $msg = $_POST['msg'];
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    if(isset($_FILES['myFile']) && !empty($_FILES['myFile']['name'])){
        $img_name = $_FILES['myFile']['name'];
        $tmp_name = $_FILES['myFile']['tmp_name'];

        $img_ext = end(explode('.',$img_name));

        if(in_array($img_ext,['png','jpeg','jpg']) === true){
            $type = "Image";
            $newimgname = time().$img_name;
            if(move_uploaded_file($tmp_name, "../../image/filemsg/".$newimgname))
            {
                $sql = "insert into message(sender_id,receiver_id,message,type,fileloc,date,time) 
                    values($sid,$rid,'$msg','$type','image/filemsg/$newimgname','$date','$time')";
                $res = mysqli_query($con, $sql);
                if($res){
                    echo "success";
                }
            }
        }
        else{
            echo "<p style='color:red;'>Please select an image file - jpg, png, jpeg</p>";
        }
    }
    else{
        echo "in else file post";
        $msg = $_POST['msg'];
        $sid = $_POST['sendid'];
        $rid = $_POST['receiveid'];
        
        if($msg != ""){
            $sql = "insert into message(sender_id,receiver_id,message,date,time) 
                values($sid,$rid,'$msg','$date','$time')";
            $res = mysqli_query($con, $sql);
            if($res){
                echo "success";
            }
        }
    }
    
}
echo "outer world";
?>