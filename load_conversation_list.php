<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$q1=mysqli_query($conn,"select * from `conversation` where `receiverid`='$sessionid';");
if(mysqli_num_rows($q1)!=0){
while($f1=mysqli_fetch_assoc($q1))
{
	$cid=$f1['cid'];
	$senderid=$f1['senderid'];
	$q2=mysqli_query($conn,"select * from `message` where `cid`='$cid' order by `m_id` desc limit 1;");
	$f2=mysqli_fetch_assoc($q2);
	$message=$f2['reply'];
	$q3=mysqli_query($conn,"select * from `users` where `userid`='$senderid';");
	$f3=mysqli_fetch_assoc($q3);
	$view_sender_name=$f3['username'];
	$q4=mysqli_query($conn,"select * from `profile_pic` where `userid`='$senderid';");
	
if(mysqli_num_rows($q4)==0)
{
	$image_path="/images/avatar.png";

}
else
{
	
	$f4=mysqli_fetch_assoc($q4);
$image_path=$f4['image_path'];
}
	//$q4=mysqli_query($conn,"select * from `user_detail` where `userid`='$senderid';");
	//$f4=mysqli_fetch_assoc($q4);
	//$user_status=$f4['user_status'];
	//string functions and exception condition if no rows exists
	
	$response=1;
	$list[]=array('response'=>$response,'senderid'=>$senderid,'cid'=>$cid,'message'=>$message,'view_sender_name'=>$view_sender_name,'sessionid'=>$sessionid,'image_path'=>$image_path);
}
}
else{
	$response=2;
	$list[]=array('response'=>$response,'senderid'=>null,'cid'=>null,'message'=>null,'view_sender_name'=>null,'sessionid'=>null,'image_path'=>null);
	
}
echo json_encode($list);
?>