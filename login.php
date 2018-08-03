<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
if((!empty($obj->email))and(!empty($obj->password)))
{
	$email=test_input($obj->email);
			$password=test_input($obj->password);
		$password=hashing($password,$email);
	$query="select * from `users` where `email`='$email';";
	$q1=mysqli_query($conn,$query);
	if(mysqli_num_rows($q1)==1)
	{

		//$q2=mysqli_query($conn,"select * from `users` where `email`='$email' and `password`='$password1';");
		$query2="select * from `users` where `email`='$email' and `password`='$password';";
		$q2=mysqli_query($conn,$query2);
		if(mysqli_num_rows($q2)==1)
		{
		$f2=mysqli_fetch_assoc($q2);
		$userid=$f2['userid'];
		$_SESSION['uid']=$userid;
		$username=$f2['username'];
		$response_data=5;
			
		}
		else{
			
			//$f100=mysqli_fetch_assoc($q1);
			
		$response_data=6;
		$userid=0;
		$username="unregistered";}
	
}
	else{
	$response_data=7;
	$userid=0;
		$username="unregistered";
	}
}
else{
	$response_data=8;
	$userid=0;
		$username="unregistered";
}
$list[]=array('response_data'=>$response_data,'userid'=>$userid,'username'=>$username);
echo json_encode($list);
?>