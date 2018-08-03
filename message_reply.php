<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$userid=$obj->userid;
if((isset($userid))and(isset($_GET['id'])))
{
	$view_id=$_GET['id'];
	$user_one_id=$userid;
	$user_two_id=$view_id;
	
	global $cid1;
	if($user_one_id!=$user_two_id)
	{
		$q3=mysqli_query($conn,"select `c_id` from `conversation` where `user_one_id`='$user_one_id' and `user_two_id`='$user_two_id';");
		$f3=mysqli_fetch_assoc($q3);
		$cid=$f3['c_id'];
		if($cid===NULL)
		{
			$q4=mysqli_query($conn,"insert into `conversation`(`user_one_id`,`user_two_id`)values('$user_one_id','$user_two_id');");
			echo "<meta content=\"0;message_reply.php?id=".$view_id."\" http-equiv=\"refresh\">";
		}
		$q5=mysqli_query($conn,"select * from `conversation_reply` where `c_id` in (select `c_id` from `conversation` where (`user_one_id`='$userid'and `user_two_id`='$view_id')or (`user_one_id`='$view_id' and`user_two_id`='$userid')) order by `cr_id`;");
		while($f5=mysqli_fetch_assoc($q5))
		{
			$reply=$f5['reply'];
			$sender=$f5['sender_id'];
			$receiver=$f5['reciever_id'];
			$cid1=$f5['c_id'];
			$cr_id=$f5['cr_id'];
			$q1=mysqli_query($conn,"select * from `users` where `user_id`='$sender';");
	$q2=mysqli_query($conn,"select * from `users` where `user_id`='$receiver';");
	$f1=mysqli_fetch_assoc($q1);
	$f2=mysqli_fetch_assoc($q2);
	$username1=$f1['username'];
	$username2=$f2['useraname'];
			$list[]=array('username_sender'=>$username,'username_receiver'=>$username2,'$reply'=>$reply,'$cid1'=>$cid1,'cr_id'=>$cr_id,'sender_id'=>$sender,'receiver'=>$receiver);
		}
		echo json_encode($list);
		flush();
	}
	echo'<script>you cannot send message to yourself</script>'
	
}
else
{
	echo "<meta content=\"0;home.php\" http-equiv=\"refresh\">";
}

?>