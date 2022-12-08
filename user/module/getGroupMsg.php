<?php
session_start();
include '../db.php';

$msgdate = "";
if(isset($_POST['senderid']) && isset($_POST['groupid'])){
    $output = "";
    $sid = $_POST['senderid'];
    $gid = $_POST['groupid'];
    
    $msgsql = "select * from groupmessage where groupid = $gid order by msgid asc";
    $msgres = mysqli_query($con, $msgsql);
                      
    if(mysqli_num_rows($msgres) > 0){
        while($chat = mysqli_fetch_assoc($msgres)){
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
            if($chat['senderid'] == $sid){
                $output .= "<div class='own-text'>
                                <div class='own-text-bubble'>
                                    <div class='msgtext'>$chat[message]</div>
                                    <div class='msgtime'>$chat[time]</div>
                                </div>
                            </div>";
            }
            else{
                $getsqldata = "select * from user where userid = $chat[senderid]";
                $userres = mysqli_query($con,$getsqldata);
                if($userres){
                    if(mysqli_num_rows($userres)){
                        $senderdata = mysqli_fetch_assoc($userres);
                    }
                }
                $output .= "<div class='user-text'>
                <img class='senderimg' src='../$senderdata[image]' width='30px' height='30px' />
                <div class='user-text-bubble'>";
                if(isset($senderdata)){
                    $output .= "<div style='font-size:12px; color:red;font-weight:bold;' class='msgtext'>$senderdata[name] </div>";
                }
                        
                $output .= "<div  class='msgsendername'>$chat[message]</div>
                        <div class='msgtime'>$chat[time]</div>
                    </div>
                </div>";
            }
        }
    }
    echo $output;
}
?>