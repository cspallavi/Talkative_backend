<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$sessionid=$obj->sessionid;

$old_password=$obj->old_password;
$new_password=$obj->new_password;
$cnew_password=$obj->cnew_password;
//$response=1;
//$list[]=array('sessionid'=>$sessionid,'response'=>$response,'old_password'=>$old_password,'new_password'=>$new_password,'cnew_password'=>$cnew_password);
//echo json_encode($list);
if(($old_password!=null)and($new_password!=null)and($cnew_password!=null))
{
if($new_password==$cnew_password)
{
$new_password=test_input($new_password);

$old_password=test_input($old_password);
	$q1=mysqli_query($conn,"select * from `users` where `userid`='$sessionid';");
	$f1=mysqli_fetch_assoc($q1);
	$email=$f1['email'];
	$password=$f1['password'];
	
	$old_password=hashing($old_password,$email);
	if($old_password==$f1['password']){
	$new_password=hashing($new_password,$email);
	if($new_password!=$old_password)
	{
		
		$q2=mysqli_query($conn,"update `users` set `password`='$new_password' where `userid`='$sessionid';");
		$response=1;
	}
	else
	$response=2;
	}
	else 
		$response=3;
	
}
else
	$response=4;
}
else
	$response=5;
$list[]=array('sessionid'=>$sessionid,'response'=>$response);
echo json_encode($list);

?>