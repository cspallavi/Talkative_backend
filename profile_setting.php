<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$name=$obj->Name;
$sessionid=$obj->sessionid;

$max_qualification=$obj->max_qualification;
$studied_in=$obj->studied_in;
$workplace=$obj->workplace;
$lives_in=$obj->lives_in;
$marital_status=$obj->marital_status;
$age=$obj->age;
$status=$obj->user_status;
$name=test_input($name);

$max_qualification=test_input($max_qualification);
$studied_in=test_input($studied_in);
$workplace=test_input($workplace);
$lives_in=test_input($lives_in);
$marital_status=test_input($marital_status);
$status=test_input($status);

$q0=mysqli_query($conn,"select * from `user_detail` where `userid`='$sessionid';");
$q5=mysqli_query($conn,"update `users` set `username`='$name' where `userid`='$sessionid';");
if(mysqli_num_rows($q0)!=0){
$q1=mysqli_query($conn,"update `user_detail` set `max_qualification`='$max_qualification',`studied_in`='$studied_in',`workplace`='$workplace',`lives_in`='$lives_in',`marital_status`='$marital_status',`user_status`='$status',`age`='$age' where `userid`='$sessionid';");
$response=1;
}
else
{
	$q1=mysqli_query($conn,"insert into `user_detail`(`userid`,`max_qualification`,`studied_in`,`workplace`,`lives_in`,`marital_status`,`user_status`)values('$sessionid','$max_qualification','$studied_in','$workplace','$lives_in','$marital_status','$status');");
	$response=1;
}
$list[]=array('sessionid'=>$sessionid,'response'=>$response);
echo json_encode($list);

?>