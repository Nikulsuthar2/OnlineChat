<?php
session_start();
include '../db.php';

$msgdate = "";
$seen = "";
if(isset($_POST['sendid']) && isset($_POST['receiveid'])){
    $output = "";
    $sid = $_POST['sendid'];
    $rid = $_POST['receiveid'];
    

    $blockbtnstatus = "select * from blockeduser where blockedby = $rid and blocked = $sid";
    $blockbtnres = mysqli_query($con, $blockbtnstatus);
    if($blockbtnres){
        if(mysqli_num_rows($blockbtnres) > 0){
            $output .= "<div class='blockwarning'>
                <p class='blcokicon'>&#128683</p>
                <b>You are Blocked</b>
            </div>";
        }
        else{
            $blockbtnstatus = "select * from blockeduser where blockedby = $sid and blocked = $rid";
            $blockbtnres = mysqli_query($con, $blockbtnstatus);
            if($blockbtnres){
                if(mysqli_num_rows($blockbtnres) > 0){
                    $output .= "<div class='blockwarning'>
                        <p class='blcokicon'>&#128683</p>
                        <b>You Blocked this user</b>
                    </div>";
                }
                else{
                    $sql = "select * from message where (sender_id = $sid and receiver_id = $rid) 
                    or (sender_id = $rid and receiver_id = $sid) order by msgid asc";

                    $res = mysqli_query($con, $sql);
                    if(mysqli_num_rows($res) > 0){
                        while($chat = mysqli_fetch_assoc($res)){
                            if($chat['sender_id'] === $sid){
                                if($chat['senderclear'] != 1){
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
                                    if($chat['msg_status'] == "seen")
                                        $seen = "&#10003";
                                    else
                                        $seen = "";
                                    
                                    if($chat["type"] == "Image"){
                                        $output .= "<div class='own-image'>
                                                <div class='own-image-bubble'>
                                                <img class='msgimage' src='../$chat[fileloc]' onClick='openImage(\"".$chat["fileloc"]."\")' width='100%'>
                                                <div class='msgtext'>$chat[message]</div>
                                                    <div class='msgtime'>$chat[time] $seen</div>
                                                </div>
                                            </div>";
                                    }
                                    else{
                                        $output .= "<div class='own-text'>
                                                <div class='own-text-bubble'>
                                                <div class='msgtext'>$chat[message]</div>
                                                    <div class='msgtime'>$chat[time] $seen</div>
                                                </div>
                                            </div>";
                                    }
                                    
                                }
                            }
                            else{
                                if($chat['receiverclear'] != 1){
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
                                    if($chat['msg_status'] == "seen")
                                        $seen = "&#10003";
                                    else
                                        $seen = "";
                                    if($chat["type"] == "Image"){
                                        $output .= "<div class='user-image'>
                                                    <div class='user-image-bubble'>
                                                        <img class='msgimage' src='../$chat[fileloc]' onClick='openImage(\"".$chat["fileloc"]."\")' width='100%'>
                                                        <div class='msgtext'>$chat[message]</div>
                                                        <div class='msgtime'>$chat[time] </div>
                                                    </div>
                                                </div>";
                                    }
                                    else{
                                        $output .= "<div class='user-text'>
                                                    <div class='user-text-bubble'>
                                                        <div class='msgtext'>$chat[message]</div>
                                                        <div class='msgtime'>$chat[time] </div>
                                                    </div>
                                                </div>";
                                    }
                                    
                                }
                            }
                        }
                    }
                }
            }
            
        }
    }
    echo $output;
}
?>