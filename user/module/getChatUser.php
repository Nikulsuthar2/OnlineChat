<?php
session_start();
include '../db.php';

$senderid = [];
$recieverid = [];

$uid = $_POST['curruid'];
$output = "";


$sendersql = "select distinct sender_id from message where receiver_id = $uid order by msgid asc";
$recieversql = "select distinct receiver_id from message where sender_id = $uid order by msgid asc";

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
                $finalmsg = "You: ".$ltsmsg['message'];
            }
            else{
                $finalmsg = $ltsmsg['message'];
            }
        }

        if($udata["status"] == "online"){
            $status = "<p class='ondot' ></p>";
        }
        else{
            $status = "<p class='offdot'></p>";
        }
		$output .=  "<a href='userchat.php?uid=$udata[userid]' class='chataccbtn'>
		<div class='accdtlbox'>
			<img class='profileimg' src='../$udata[image]' width='40px' height='40px'>
			<div class='accnamebox'>
				<label class='accname'>$udata[name] $status</label>
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

echo $output;

?>