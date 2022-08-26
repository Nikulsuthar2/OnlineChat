<?php
session_start();
include '../db.php';

$nouser = "<div style='height:80px;display:flex;justify-content:center;align-items:center;'>
			<b>No User found</b></div>";

if(isset($_POST['search'])){
	$sql = "select * from user where name like '%$_POST[search]%' or email like '$_POST[search]'";
	
	$res = mysqli_query($con, $sql);

	if(mysqli_num_rows($res) > 0){
		while($data = mysqli_fetch_assoc($res)){
			if($data["userid"]==$_SESSION["uid"]){
				if(mysqli_num_rows($res) == 1)
					echo $nouser;
			}
			else
			echo "<a href='userchat.php?uid=$data[userid]' class='chataccbtn'>
				<div class='accdtlbox'>
					<img class='profileimg' src='../$data[image]' width='40px' height='40px'>
					<div class='accnamebox'>
						<label class='accname'>$data[name]</label>
						<label class='acclastmsg'>$data[status]</label>
					</div>
				</div>
			</a>";
		}
	}
	else{
		echo $nouser;
	}
}
else{
	$sql = "select * from user";
	$res = mysqli_query($con, $sql);

	if($res){
		while($data = mysqli_fetch_assoc($res)){
			echo "<a href='#' class='chataccbtn'>
			<div class='accdtlbox'>
				<img class='profileimg' src='../$data[image]' width='40px' height='40px'>
				<div class='accnamebox'>
					<label class='accname'>$data[name] without post</label>
					<label class='acclastmsg'>$data[status]</label>
				</div>
			</div>
			<label class='notibadge'>1</label>
		</a>";
		}
	}
}
?>