<?php
session_start();
include '../db.php';

$output = "";

if(isset($_POST['curruid'])){
    $uid = $_POST['curruid'];

    $sql = "select * from chatgroup where adminid = $uid";
    $res = mysqli_query($con, $sql);
    if($res){
        if(mysqli_num_rows($res) > 0){
           while($admindata = mysqli_fetch_assoc($res)){
                $output .=  "<a href='groupchat.php?gid=$admindata[groupid]' class='chataccbtn'>
                <div class='accdtlbox'>
                    <div class='profileborder owngroup'>
                        <img class='groupprofileimg' src='../$admindata[image]' width='40px' height='40px'>
                    </div>
                    <div class='accnamebox'>
                        <label class='accname'>&#128101 $admindata[groupname]</label>
                        <label class='acclastmsg'>1 Participants</label>
                    </div>
                </div>";
                $output .= "<div class='notibadge'>0</div>";
                $output .= "</a>";
           }
        }
    }

    $sql1 = "select * from gparticipants where participantid = $_SESSION[uid]";
    $res1 = mysqli_query($con, $sql1);
    if($res1){
        if(mysqli_num_rows($res1) > 0){
           while($partidata = mysqli_fetch_assoc($res1)){
                $groupsql = "select * from chatgroup where groupid = $partidata[groupid]";
                $groupres = mysqli_query($con,$groupsql);
                if($groupres){
                    if(mysqli_num_rows($groupres) > 0){
                        $lastmsg = "";
                        $groupdata = mysqli_fetch_assoc($groupres);
                        $lastmsgsql = "select * from groupmessage where groupid = $groupdata[groupid] order by msgid desc limit 1";
                        $lastmsgres = mysqli_query($con,$lastmsgsql);
                        if($lastmsgres){
                            if(mysqli_num_rows($lastmsgres) > 0){
                                $lastmsg = mysqli_fetch_assoc($lastmsgres)["message"];
                            }
                        }
                        
                        $output .=  "<a href='groupchat.php?gid=$groupdata[groupid]' class='chataccbtn'>
                        <div class='accdtlbox'>
                            <div class='profileborder'>
                                <img class='groupprofileimg' src='../$groupdata[image]' width='40px' height='40px'>
                            </div>
                                <div class='accnamebox'>
                                <label class='accname'>&#128101 $groupdata[groupname]</label>
                                <label class='acclastmsg'>$lastmsg</label>
                            </div>
                        </div>";
                        //$output .= "<div class='notibadge'></div>";
                        $output .= "</a>";
                    }
                }
           }
        }
    }
}
/*
$res1 = mysqli_query($con, $sendersql);
$res2 = mysqli_query($con, $recieversql);

if(mysqli_num_rows($res1) > 0){
    while($data1 = mysqli_fetch_assoc($res1)){
        array_push($senderid,$data1['sender_id']);
    }
}
if(mysqli_num_rows($res2) > 0){
    while($data2 = mysqli_fetch_assoc($res2)){
        array_push($recieverid,$data2['receiver_id']);
    }
}

$uniquechatid = array_unique(array_merge($senderid,$recieverid));

foreach($uniquechatid as $id){

    $blockbtnstatus = "select * from blockeduser where blockedby = $uid and blocked = $id";
    $blockbtnres = mysqli_query($con, $blockbtnstatus);
    if($blockbtnres){
        if(mysqli_num_rows($blockbtnres) > 0){
            $blocked = true;
        }
        else{
            $blocked = false;
            $blockbtnstatus = "select * from blockeduser where blockedby = $id and blocked = $uid";
            $blockbtnres = mysqli_query($con, $blockbtnstatus);
            if($blockbtnres){
                if(mysqli_num_rows($blockbtnres) > 0){
                    $blocked = true;
                }
                else{
                    $blocked = false;
                }
            }
            else{
                $blocked = false;
            }
        }
    }
    else{
        $blocked = false;
    }
    

    $sql = "select * from user where userid = $id";
    $res = mysqli_query($con, $sql);

    $newmsgsql = "select * from message where sender_id = $id and receiver_id = $uid and msg_status = 'unseen'";
    $newnoti = mysqli_query($con,$newmsgsql);

    $latestmsg = "select * from message where (sender_id = $id and receiver_id = $uid)
    or (sender_id = $uid and receiver_id = $id) order by msgid desc limit 1";
    $ltsmsgres = mysqli_query($con , $latestmsg);

    $istyping = false;
    if($res){
        $udata = mysqli_fetch_assoc($res);
        $ltsmsg =  mysqli_fetch_assoc($ltsmsgres);

        $statussql = "select * from userstatus where mainuser = $uid and otheruser = $id";
        $statusresult = mysqli_query($con,$statussql);

        if(mysqli_num_rows($statusresult) > 0){
            $row = mysqli_fetch_assoc($statusresult);
            if($row['status'] == "Typing.."){
                $istyping = true;
                $finalmsg = "<b style='color:#3aff54;'>".$row['status']."</b>";
            }
            else{
                $istyping = false;
            }
        }

        if($istyping == false){
            if($ltsmsg["sender_id"] == $_SESSION["uid"]){
                if($ltsmsg["senderclear"] != 1){
                    $finalmsg = "You: ".$ltsmsg['message'];
                    if($ltsmsg["msg_status"] == "seen")
                        $finalmsg .= " &#10003"; //&#128065
                }
                else
                    $finalmsg = null;
                
            }
            else{
                if($ltsmsg["receiverclear"] != 1)
                    $finalmsg = $ltsmsg['message'];
                else
                    $finalmsg = null;
            }
        }

        if($udata["status"] == "online"){
            $status = "<p class='ondot' ></p>";
        }
        else{
            $status = "<p class='offdot'></p>";
        }
        if(!$blocked){
            $output .=  "<a href='userchat.php?uid=$udata[userid]' class='chataccbtn'>
            <div class='accdtlbox'>
                <img class='profileimg' src='../$udata[image]' width='40px' height='40px'>
                <div class='accnamebox'>
                    <label class='accname'>$status $udata[name]</label>
                    <label class='acclastmsg'>$finalmsg</label>
                </div>
            </div>";
            if(mysqli_num_rows($newnoti) > 0){
                $noticount = mysqli_num_rows($newnoti);
                $output .= "<div class='notibadge'>$noticount</div>";
            }
            $output .= "</a>";
        }
    }
}*/
echo $output;
?>