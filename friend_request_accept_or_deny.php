<?php
include"configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$receiverid=$obj->viewuserid;
$btn=$obj->btn;
$fid=$obj->fid;
$response=0;

if($btn==1)//accept
{
	$txt="accepted";
$q1=mysqli_query($conn,"update `friends` set `request_status`='$txt' where `fid`='$fid';");	
$response=1;
}
else if($btn==2)//deny
{
	$q1=mysqli_query($conn,"delete from `friends` where `fid`='$fid';");
	$response=1;
}
else if($btn==3)//remove friends
{
	$q1=mysqli_query($conn,"delete from `friends` where `fid`='$fid';");
	$q0=mysqli_query($conn,"select * from `conversation` where (`senderid`='$sessionid' and `receverid`='$receiverid' ) or(`senderid`='$receiverid' and `receiverid`='$sessionid');");
	while($f0=mysqli_fetch_assoc($q0))
	{
	$cid=$f0['cid'];
	$q4=mysqli_query($conn,"delete from `message` where `cid`='$cid';");
	}
	$q2=mysqli_query($conn,"delete from `conversation` where (`senderid`='$sessionid' and `receiverid`='$receiverid' ) or(`senderid`='$receiverid' and `receiverid`='$sessionid');");
	$response=1;
	
}
$list[]=array('response'=>$response);
echo json_encode($list);
?>
