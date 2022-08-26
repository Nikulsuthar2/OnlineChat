<?php
include '../db.php';
if(isset($_POST['msgstatus']))
{
	$updateseensql = "update message set msg_status = 'seen' where sender_id = $_POST[rid] and receiver_id = $_POST[sid] and msg_status = 'unseen'";
    $updateres = mysqli_query($con,$updateseensql);
	if($updateres)
	{
		echo "status updated";
	}
}

?>