<?php
include "configuration.php";
$json=file_get_contents('php://input');
$obj=json_decode($json);
$mid=$obj->mid;
$q1=mysqli_query($conn,"delete from `message` where `m_id`='$mid';");
//after calling this service service load_conversation_list has to be called
$response=1;
$list[]=array('response'=>$response);
echo json_encode($list);
?>