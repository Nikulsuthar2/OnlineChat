<?php
session_start();
include '../db.php';

$msgdate = "";
if(isset($_POST['sendid']) && isset($_POST['receiveid'])){
    $output = "";
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    
    $sql = "select * from message where (sender_id = $sid and receiver_id = $rid) 
    or (sender_id = $rid and receiver_id = $sid) order by msgid asc";

    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0){
        while($chat = mysqli_fetch_assoc($res)){
            if($msgdate != $chat['date']){
                $yesterday = date_format(date_sub(date_create(Date("Y-m-d")),date_interval_create_from_date_string("1 days")),"Y-m-d");
                $msgdate = $chat['date'];
                if($msgdate == Date("Y-m-d")){
                    $output .= "<div class='datebox'><label class='datetext'>Today</label></div>";
                }
                else if($msgdate == $yesterday){
                    $output .= "<div class='datebox'><label class='datetext'>Yesterday</label></div>";
                }
                else{
                    $output .= "<div class='datebox'><label class='datetext'>".date_format(date_create($chat["date"]),"d-M-Y")."</label></div>";
                }
            }
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