<?php
include 'db.php';
$chatsql = "select distinct sender_id from message where receiver_id = 10  
union select distinct receiver_id from message where sender_id = 10";

$totcres = mysqli_query($con, $chatsql);
if($totcres)
    while($data = mysqli_fetch_assoc($totcres)){
        print_r($data);
    }
    $totalchats = mysqli_num_rows($totcres);
    echo "total data : $totalchats";
?>