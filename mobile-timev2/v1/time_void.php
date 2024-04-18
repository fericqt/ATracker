<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

	$db = new DBOperations();

	$checkVoid = $db->timeVoided($_POST['email'], intval($_POST['last_id']), intval($_POST['required_hours']));
	if($checkVoid == "void"){
		$response['error'] = false;
		$response['message'] = "Your time rendered has been voided since you haven't successfully time-out. Please be responsible next time.";
	}else if($checkVoid == "reset"){
		$response['error'] = false;
		$response['message'] = "";

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