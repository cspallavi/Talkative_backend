<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$senderid=$obj->sessionid;
$receiverid=$obj->userid2;
$fid=$obj->fid;
$message=$obj->message;
$message=test_input($message);
$n="no";
if(($message!=null)and($message!=" "))
{//$message=mysqli_real_escape_string($conn,htmlspecialchars($obj->message));
$q0=mysqli_query($conn,"select * from `friends` where `fid`='$fid';");
//if(mysqli_num_rows($q0)!=0)
//{
$q1=mysqli_query($conn,"select * from `conversation` where `senderid`='$senderid' and `receiverid`='$receiverid';");
if(mysqli_num_rows($q1)!=0)
{
	$f1=mysqli_fetch_assoc($q1);
	$cid=$f1['cid'];
	$q4=mysqli_query($conn,"insert into `message`(`cid`,`msgsenderid`,`msgreceiverid`,`reply`,`seen`)values('$cid','$senderid','$receiverid','$message','$n');");
}
else
{ 
	
	$q2=mysqli_query($conn,"insert into `conversation`(`senderid`,`receiverid`)values('$senderid','$receiverid');");
	$q3=mysqli_query($conn,"select * from `conversation` where `senderid`='$senderid' and `receiverid`='$receiverid';");
	$f3=mysqli_fetch_assoc($q3);
	$cid=$f3['cid'];
	$q4=mysqli_query($conn,"insert into `message`(`cid`,`msgsenderid`,`msgreceiverid`,`reply`,`seen`)values('$cid','$senderid','$receiverid','$message','$n');");
	
}
$q6=mysqli_query($conn,"select * from `users` where `userid`='$senderid';");
	$f6=mysqli_fetch_assoc($q6);
	$username=$f6['username'];
	
$q5=mysqli_query($conn,"select * from `profile_pic` where `userid`='$senderid';");
//$f5=mysqli_fetch_assoc($q5);
//$image_path=$f5['image_path'];
if(mysqli_num_rows($q5)==0)
{
	$image_path="/images/avatar.png";

}
else
{
	
	$f5=mysqli_fetch_assoc($q5);
$image_path=$f5['image_path'];
}
$response=1;
/*$q5=mysqli_query($conn,"select * from `message` where `cid`='$cid';");
while($f4=mysqli_fetch_assoc($q5))
{
	
	$m_id=$f4['m_id'];
	
}*/
$list[]=array('response'=>$response,'cid'=>$cid,'message'=>$message,'senderid'=>$senderid,'username'=>$username,'image_path'=>$image_path);


//$list[]=array('response'=>$response,'cid'=>$cid,'mid'=>$);
echo json_encode($list);
//}
/*else
{
	$list[]=array('response'=>3);
	echo json_encode($list);
}*/
}
else
	$list[]=array('response'=>2);
echo json_encode($list);

flush();
?>