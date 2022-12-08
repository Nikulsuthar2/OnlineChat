<?php
session_start();
include '../db.php';

$nouser = "<div style='height:80px;display:flex;justify-content:center;align-items:center;'>
			<b>No User found</b></div>";

if(isset($_POST['search'])){
	$sql = "select * from user where name like '%$_POST[search]%' or email like '$_POST[search]'";
	
	$res = mysqli_query($con, $sql);

	if(mysqli_num_rows($res) > 0){
        $notallowed = [];
        if(isset($_POST['included'])){
            if($_POST['included'] != "none"){
                $notallowed = explode(",",$_POST['included']);
            }
        }
		while($data = mysqli_fetch_assoc($res)){
			if($data["userid"]==$_SESSION["uid"]){
				if(mysqli_num_rows($res) == 1)
					echo $nouser;
			}
			else{
				$blockbtnstatus = "select * from blockeduser where blockedby = $data[userid] and blocked = $_SESSION[uid]";
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

                if(!$blocked){
                    if(!in_array("$data[userid]",$notallowed)){
                        echo "<div href='userchat.php?uid=$data[userid]' class='useraddchip'>
					    <div class='userdtlbox'>
                            <img class='profileimg' src='../$data[image]' width='30px' height='30px'>
                            <label class='accname'>$data[name]</label>
                        </div>
                        <input type='button' class='useraddbtn' onClick='adduser($data[userid])'  value= 'Add'>
                    </div>";
                    }
					else{
						echo $nouser;
					}
                }
				
			}
		}
	}
	else{
		echo $nouser;
	}
}
?>