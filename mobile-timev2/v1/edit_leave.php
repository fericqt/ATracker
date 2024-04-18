<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$user_input = array("leave_reason" => $_POST['leave_reason'],
						"leave_reason_details"=>$_POST['leave_reason_details'],
						"date_start"=>$_POST['date_start'],
						"date_end"=>$_POST['date_end']);

	if($db->updateLeave((int)$_POST['leave_ID'], $user_input)){
		$response['error'] = false;
		$response['message'] = "Data has been updated.";
	}else{
		$response['error'] = true;
		$response['message'] = "DB: Something went wrong.";
	}


}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>