<?php
session_start();
include '../db.php';


$success = false;
if(isset($_SESSION["uid"])){
    if(isset($_POST["gname"]) && isset($_POST["uids"])){
        $gid = time();
        $sql = "insert into chatgroup(groupid,adminid,groupname,image) values($gid,$_SESSION[uid],'$_POST[gname]','image/profileimg/groupdef.png')";
        $res = mysqli_query($con, $sql);

        if($res){
            if($_POST["uids"] != ""){
                $notallowed = explode(",",$_POST['uids']);
            
                foreach($notallowed as $id){
                    $success = false;
                    $partisql = "insert into gparticipants(groupid,participantid) values($gid,$id)";
                    $partires = mysqli_query($con, $partisql);
                    if($partires){
                        $success = true;
                    }
                }
                if($success){
                    echo "Group Created";
                }
            }
            
        }
    }
}

?>