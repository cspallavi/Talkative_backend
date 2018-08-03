<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$q1=mysqli_query($conn,"select * from `users`;");
while($f1=mysqli_fetch_assoc($q1)){
$userid=$f1['userid'];
$username=$f1['username'];
$q2=mysqli_query($conn,"select * from `user_detail` where `userid`='$userid' ;");
$f2=mysqli_fetch_assoc($q2);
$status=$f2['user_status'];
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


$list[]=array('userid'=>$userid,'username'=>$username,'status'=>$status,'profile_pic'=>$image_path,'sessionid'=>$sessionid);

}
echo json_encode($list);
?>