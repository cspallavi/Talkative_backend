<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$txt="accepted";
$q1=mysqli_query($conn,"select * from `friends` where (`friend_request_sent_from`='$sessionid' and `request_status`='$txt')or(`friend_request_sent_to`='$sessionid' and `request_status`='$txt');");
$no_of_friends=mysqli_num_rows($q1);
//$no_of_friends=0;

if($no_of_friends!=0){
while($f1=mysqli_fetch_assoc($q1))
{
	$userid1=$f1['friend_request_sent_from'];
	$userid2=$f1['friend_request_sent_to'];
	if($userid1!=$sessionid)
	{
		$friendid=$userid1;
		
	}
	else
		$friendid=$userid2;
	$q2=mysqli_query($conn,"select * from `users` where`userid`='$friendid';");
	$f2=mysqli_fetch_assoc($q2);
	$friend_name=$f2['username'];
	$q3=mysqli_query($conn,"select * from `user_detail` where `userid`='$friendid';");
	$f3=mysqli_fetch_assoc($q3);
	$status1=$f3['user_status'];
	$q4=mysqli_query($conn,"select * from `profile_pic` where `userid`='$friendid';");
	if(mysqli_num_rows($q4)==0)
{
	$image_path="/images/avatar.png";

}
else
{
	
	$f4=mysqli_fetch_assoc($q4);
$image_path=$f4['image_path'];
}
$response=1;
	$list[]=array('response'=>$response,'friendid'=>$friendid,'sessionid'=>$sessionid,'friend_name'=>$friend_name,'no_of_friends'=>$no_of_friends,'status'=>$status1,'image_path'=>$image_path);
}
}
else{
$response=2;
$list[]=array('response'=>$response,'friendid'=>null,'sessionid'=>null,'friend_name'=>null,'no_of_friends'=>null,'status'=>null,'image_path'=>null);	
}
echo json_encode($list);

?>