<?php
/*include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
$view_userid=$obj->view_userid;
$q1=mysqli_query($conn,"select * from `message` where(`msgsenderid`='$sessionid' and `msgreceiverid`='$view_userid')or(`msgsenderid`='$view_userid' and `msgreceiverid`='$sessionid');");
$count_messages=mysqli_num_rows($q1);
$list[]=array('count_messages'=>$count_messages);
echo json_encode($list);*/

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include "configuration.php";

//echo rand("sdfdasd");
//$time = date('r');
//echo "data: The server time is: {$time}\n\n";
//flush();

$json=file_get_contents('php://input');

$obj=json_decode($json);
$sessionid=$obj->sessionid;
$view_userid=$obj->view_userid;

//$sessionid = $_SERVER['sender'];
//$view_userid = $_SERVER['user'];
echo "Sender - ".$sessionid." User - ".$view_userid;
//$myfile = fopen("testfile.txt", "w")
//fwrite($myfile, "Sender - ".$sessionid." User - ".$view_userid);
$y="yes";
$n="no";
$q1=mysqli_query($conn,"select * from `message` where (`msgsenderid`='$view_userid' and `msgreceiverid`='$sessionid')and `seen`='$n' order by `m_id` desc;");
if(mysqli_num_rows($q1)!=0)
{	
while($f1=mysqli_fetch_assoc($q1))
{
	$mid=$f1['m_id'];
	$q20=mysqli_query($conn,"update `message` set `seen`='$y' where `m_id`='$mid';");
	$cid=$f1['cid'];
	$msgsenderid=$f1['msgsenderid'];
	$message=$f1['reply'];
	$q3=mysqli_query($conn,"select * from `users` where `userid`='$msgsenderid';");
	$f3=mysqli_fetch_assoc($q3);
	$sender_name=$f3['username'];
	//$q4=mysqli_query($conn,"select * from `profile_pic` where `userid`='$msgsenderid';");
	//$f4=mysqli_fetch_assoc($q4);
	//$image_path=$f4['image_path'];
	$q5=mysqli_query($conn,"select * from `profile_pic` where `userid`='$msgsenderid';");
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
$q6=mysqli_query($conn,"select * from `friends` where(`friend_request_sent_from`='$sessionid' and `friend_request_sent_to`='$view_userid')or(`friend_request_sent_from`='$view_userid' and  `friend_request_sent_to`='$sessionid');");
	$f6=mysqli_fetch_assoc($q6);
	$fid=$f6['fid'];
	$response=1;
	$list1[]=array('response'=>$response,'fid'=>$fid,'sessionid'=>$sessionid,'m_id'=>$mid,'senderid'=>$msgsenderid,'message'=>$message,'sender_name'=>$sender_name,'image_path'=>$image_path);
//echo json_encode($list1);
	}
}
else{
	//$response=2;
	$list1[]=array('response'=>2,'fid'=>null,'sessionid'=>null,'m_id'=>null,'senderid'=>null,'message'=>null,'sender_name'=>null,'image_path'=>null);
}
echo json_encode($list1);

//flush();
?>
