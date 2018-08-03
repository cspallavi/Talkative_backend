<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;
//$friend_request_sent_from=$sessionid;
$friend_request_sent_to=$obj->friend_request_sent_to;
$txt="requested";
//$list[]=array('response'=>1,'sessionid'=>$sessionid,'friend_request_sent_to'=>$friend_request_sent_to);
//echo json_encode($list);
$q6=mysqli_query($conn,"select * from `friends` where(`friend_request_sent_from`='$sessionid' and`friend_request_sent_to`='$friend_request_sent_to')or(`friend_request_sent_from`='$friend_request_sent_to' and  `friend_request_sent_to`='$sessionid')");
if(mysqli_num_rows($q6)==0)
{
$q1=mysqli_query($conn,"insert into `friends`(`friend_request_sent_from`,`friend_request_sent_to`,`request_status`)values('$sessionid','$friend_request_sent_to','$txt');");
$list[]=array('response'=>1,'sessionid'=>$sessionid,'friend_request_sent_to'=>$friend_request_sent_to);
}
else
{
$list[]=array('response'=>0);
}
echo json_encode($list);


?>
