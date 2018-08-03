<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$txt="requested";
$q1=mysqli_query($conn,"select * from `friends` where `friend_request_sent_to`='$sessionid' and `request_status`='$txt';");
if(mysqli_num_rows($q1)!=0)
{
while($f1=mysqli_fetch_assoc($q1))
{
	$fid=$f1['fid'];
	$userid=$f1['friend_request_sent_from'];
	$q2=mysqli_query($conn,"select * from `users` where `userid`='$userid';");
	$f2=mysqli_fetch_assoc($q2);
	$name=$f2['username'];
	$q3=mysqli_query($conn,"select * from `user_detail` where `userid`='$userid';");
	$f3=mysqli_fetch_assoc($q3);
	$status1=$f3['user_status'];
	$q4=mysqli_query($conn,"select * from `profile_pic` where `userid`='$userid';");
if(mysqli_num_rows($q4)==0)
{
	$image_path="/images/avatar.png";

}
else
{
	
	$f4=mysqli_fetch_assoc($q4);
$image_path=$f4['image_path'];
}
	$list[]=array('response'=>1,'fid'=>$fid,'userid'=>$userid,'username'=>$name,'status'=>$status1,'profile_pic'=>$image_path);
	//$list[]= array('fid'=>null,'userid'=>null,'username'=>null,'status'=>null,'profile_pic'=>null);
	
}
}
else
{
	$list[]=array('response'=>2);
}
//$list[]= array('fid'=>null,'userid'=>null,'username'=>null,'status'=>null,'profile_pic'=>null);
echo json_encode($list);
?>