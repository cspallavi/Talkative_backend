<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);

$userid=$obj->userid;
//$userid=24;
$q1=mysqli_query($conn,"select * from `users` where `userid`='$userid';");
$f1=mysqli_fetch_assoc($q1);
$username=$f1['username'];
$q2=mysqli_query($conn,"select * from `user_detail` where `userid`='$userid';");
$f2=mysqli_fetch_assoc($q2);
$user_status=$f2['user_status'];
//$gender=$f2['gender'];
$qualification=$f2['max_qualification'];
$studied_in=$f2['studied_in'];
$workplace=$f2['workplace'];
$marital_status=$f2['marital_status'];
$age=$f2['age'];
$lives_in=$f2['lives_in'];
$txt="accepted";
$q3=mysqli_query($conn,"select * from `friends` where (`friend_request_sent_from`='$userid' and `request_status`='$txt')or(`friend_request_sent_to`='$userid' and `request_status`='$txt');");
$no_of_friends=mysqli_num_rows($q3);
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
$list[]=array('age'=>$age,'userid'=>$userid,'username'=>$username,'status'=>$user_status,'qualification'=>$qualification,'studied_in'=>$studied_in,
'workplace'=>$workplace,'marital_status'=>$marital_status,'profile_pic'=>$image_path,'no_of_friends'=>$no_of_friends,'lives_in'=>$lives_in);
echo json_encode($list);
?>