<?php
include "configuration.php";
$json=file_get_contents("php://input");
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$txt="accepted";
$q1=mysqli_query($conn,"select * from `user_detail` where `userid`='$sessionid';");
$q10=mysqli_query($conn,"select * from `users` where `userid`='$sessionid';");
$q3=mysqli_query($conn,"select * from `friends` where (`friend_request_sent_from`='$sessionid' or `friend_request_sent_to`='$sessionid') and `request_status`='$txt';");
	$friends=mysqli_num_rows($q3);
	$f10=mysqli_fetch_assoc($q10);
if(mysqli_num_rows($q1)!=0)
{
	$f1=mysqli_fetch_assoc($q1);
	

	$Name=$f10['username'];
	$user_status=$f1['user_status'];
	$lives_in=$f1['lives_in'];
	$studied_in=$f1['studied_in'];
	$workplace=$f1['workplace'];
	$marital_status=$f1['marital_status'];
	
	
	$qualify=$f1['max_qualification'];
	$age=$f1['age'];
	
	$q5=mysqli_query($conn,"select * from `profile_pic` where `userid`='$sessionid';");
//$f5=mysqli_fetch_assoc($q5);
//$image_path=$f5['image_path'];
if(mysqli_num_rows($q5)==0)
{
	$image="/images/avatar.png";

}
else
{
	
	$f5=mysqli_fetch_assoc($q5);
$image=$f5['image_path'];
}
$list[]=array('Name'=>$Name,'user_status'=>$user_status,'lives_in'=>$lives_in,'studied_in'=>$studied_in,'workplace'=>$workplace,'marital_status'=>$marital_status,'friends'=>$friends,'qualify'=>$qualify,'age'=>$age,'image'=>$image);
}
else
{
	$q10=mysqli_query($conn,"select * from `users` where `userid`='$sessionid';");
	$f10=mysqli_fetch_assoc($q10);
	$image="/images/avatar.png";
	$Name=$f10['username'];
	
	$list[]=array('Name'=>$Name,'user_status'=>null,'lives_in'=>null,'studied_in'=>null,'workplace'=>null,'marital_status'=>null,'friends'=>$friends,'qualify'=>null,'age'=>null,'image'=>$image);
}
echo json_encode($list);	
?>