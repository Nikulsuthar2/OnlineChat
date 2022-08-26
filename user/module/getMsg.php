<?php
session_start();
include '../db.php';

if(isset($_POST['sendid']) && isset($_POST['receiveid'])){
    $output = "";
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    
    $sql = "select * from message where (sender_id = $sid and receiver_id = $rid) 
    or (sender_id = $rid and receiver_id = $sid) order by msgid asc";

    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0){
        while($chat = mysqli_fetch_assoc($res)){
            if($chat['sender_id'] === $sid){
                $output .= "<div class='own-text'>
                                <div class='own-text-bubble'>
                                    <div class='msgtext'>$chat[message]</div>
                                    <div class='msgtime'>$chat[time]</div>
                                </div>
                            </div>";
            }
            else{
                $output .= "<div class='user-text'>
                                <div class='user-text-bubble'>
                                    <div class='msgtext'>$chat[message]</div>
                                    <div class='msgtime'>$chat[time]</div>
                                </div>
                            </div>";
            }
        }
        echo $output;
    }
}
?>