<?php
include 'db.php';
if(isset($_POST["delid"])){
    $delid = $_POST["delid"];

    $sql = "delete from user where userid = $delid";
    $res = mysqli_query($con, $sql);
    if($res){
        $sql2 = "delete from message where sender_id = $delid or receiver_id = $delid";
        $res2 = mysqli_query($con, $sql2);
        if($res2)
            echo "sucess";
    }
    else{
        echo "failed";
    }
}
else{
    echo "del id not seted";
}
?>