<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="chathub";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
//$db_name = "chat_db"; 

//$conn1 = new mysqli($servername,$username,$password,$db_name,true);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else
	
	//echo "Connection successfully done....Please wait while you are redirected...";
session_start();

function test_input($data)
{
$data=trim($data);

$data=stripslashes($data);
$data=htmlspecialchars($data);
$data=htmlspecialchars($data,ENT_QUOTES);
return $data;
}
function formatDate($date)
{
	return date('g:i a', strtotime($date));
}
function hashing($password,$email)
{
	 
	$salt=sha1($email);
	
	$password1=md5(htmlspecialchars($password));
	 $pass=crypt($password1,$salt);
	
	$pass1=$pass.'1437';
	
	$hashpass=hash("sha512",$pass1);
	
	return $hashpass;
}
function hashing1($email)
{
	$salt=sha1($email);
	$pass=$salt.'1437';
	$hashpass=hash("sha512",$pass);
	return $hashpass;
}


?>