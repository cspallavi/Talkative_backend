<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$cid=$obj->cid;
$q=mysqli_query($conn,"delete from `message` where `cid`='$cid';");
$q1=mysqli_query($conn,"delete from `conversation` where `cid`='$cid';");
$response=1;
$list[]=array('response'=>$response);
echo json_encode($list);

?>