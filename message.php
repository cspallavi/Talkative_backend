<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$userid=$obj->userid;
if (isset($userid))
{
	$q1=mysqli_query($conn,"select * from `users` where `user_id`='$userid';");
	$f1=mysqli_fetch_assoc($q1);
	$username=$f1['username'];
	$q2=mysqli_query($conn,"select * from `conversation` where `user_one_id`='$userid' or `user_two_id`='$userid';");
	$f2=mysqli_fetch_assoc($q2);
	$c_id=$f2['c_id'];
	$q3=mysqli_query($conn."select * from `conversation_reply` where `c_id`='$c_id';");
	$f3=mysqli_fetch_assoc($q3);
	
	$sender=$f3['sender_id'];
	$receiver=$f3['reciever_id'];
	if($sender!=$userid)
	{
    $q4=mysqli_query($conn,"select * from `conversation_reply` where `sender_id`='$userid' or `reciever_id`='$userid';");
	$f4=mysqli_fetch_assoc($q4);
	$reply=$f4['reply'];
	$q5=mysqli_query($conn,"select * from `users` where `user_id`='$sender';");
	$f5=mysqli_fetch_assoc($q5);
	$username_sender=$f5['username'];
	}
	else
	{$reply=null;
	$username_sender=null;
	
	}
	$list[]=array('username'=>$username,'username_sender'=>$username_sender,'reply'=>$reply);
echo(json_encode($list));

	}
else
{echo "<meta content=\"0;home.php\" http-equiv=\"refresh\">";
}

?>