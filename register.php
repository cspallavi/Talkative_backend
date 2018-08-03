<?php
include 'configuration.php';
$json=file_get_contents('php://input');
$obj=json_decode($json);
if((!empty($obj->email))and(!empty($obj->username))and(!empty($obj->password))and(!empty($obj->cpassword)))
{
	$email=test_input($obj->email);
	$username=test_input($obj->username);
	$password=test_input($obj->password);
	$cpassword=test_input($obj->cpassword);
	$password=hashing($password,$email);
	$cpassword=hashing($cpassword,$email);
	$query="select * from `users` where `email`='$email';";
	$q1=mysqli_query($conn,$query);
	if(mysqli_num_rows($q1)==0)
	{
		if(strcmp($password,$cpassword)==0)
		{
			$query="insert into `users`(`username`,`email`,`password`)values('$username','$email','$password');";
			$q3=mysqli_query($conn,$query);
			$query10="select * from `users` where `email`='$email' and `password`='$password';";
			$q2=mysqli_query($conn,$query10);
			$f2=mysqli_fetch_assoc($q2);
			$userid=$f2['userid'];
			$response_data=1;
			$username=$f2['username'];
			$list[]=array('response_data'=>$response_data,'userid'=>$userid,'username'=>$username);
		
		}
		else
		{
			$response_data=2;
		   $userid=0;
		   $username="unregistered";
		   $list[]=array('response_data'=>$response_data,'userid'=>$userid,'username'=>$username);
		}
		
	}
	
	
}
else{
	$response_data=4;
	$userid=0;
	$username="unregistered";
	$list[]=array('response_data'=>$response_data,'userid'=>$userid,'username'=>$username);
}

			echo json_encode($list);
?>