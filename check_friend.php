<?php
include "configuration.php";
$json=file_get_contents("php://input");
$obj=json_decode($json);
$userid=$obj->userid;
$sessionid=$obj->sessionid;
$txt="accepted";
$txt1="requested";//do job 
$q1=mysqli_query($conn,"select * from `friends` where ((`friend_request_sent_to`='$userid' and `friend_request_sent_from`='$sessionid')or(`friend_request_sent_to`='$sessionid' and `friend_request_sent_from`='$userid')) and `request_status`='$txt' ;");
if(mysqli_num_rows($q1)!=0)
{
$response=1;
}
else
{
	$response=0;
}

if($userid==$sessionid)
{
	$response=2;
}
$q2=mysqli_query($conn,"select * from `friends` where `friend_request_sent_from`='$sessionid' and `friend_request_sent_to`='$userid' and  `request_status`='$txt1';");
if(mysqli_num_rows($q2)!=0)
{
$response=3;
}
$q3=mysqli_query($conn,"select * from `friends` where `friend_request_sent_from`='$userid' and `friend_request_sent_to`='$sessionid' and  `request_status`='$txt1';");
if(mysqli_num_rows($q3)!=0)
{
	$response=4;
}
$list[]=array('response'=>$response);
echo json_encode($list);
	?>