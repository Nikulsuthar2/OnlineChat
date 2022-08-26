<?php
session_start();
include '../db.php';

if(isset($_POST["updatepro"]))
{
    $upsql = "";
    if(isset($_FILES['profileimg']) && !empty($_FILES['profileimg']['name'])){
        $img_name = $_FILES['profileimg']['name'];
        $tmp_name = $_FILES['profileimg']['tmp_name'];

        $img_ext = end(explode('.',$img_name));

        if(in_array($img_ext,['png','jpeg','jpg']) === true){
            $newimgname = time().$img_name;
            if(move_uploaded_file($tmp_name, "../../image/profileimg/".$newimgname))
            {
                $upsql = "update user set image = 'image/profileimg/$newimgname', name = '$_POST[uname]' where userid = $_SESSION[uid]";
            }
        }
        else{
            echo "<p style='color:red;'>Please select an image file - jpg, png, jpeg</p>";
        }
    }
    else{
        $upsql = "update user set name = '$_POST[uname]' where userid = $_SESSION[uid]";
    }
    if($upsql != ""){
        $res = mysqli_query($con, $upsql);
        if($res){
            header("location: ../userhome.php");
        }
        else{
            echo "<p style='color:red;'>Something went wrong</p>";
        }
    }
}

?>