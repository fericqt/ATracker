<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

	$db = new DBOperations();
	date_default_timezone_set('Asia/Manila');
	
	$day = date('F d, Y');
	$time = date('g:i A');
	
	$date_applied = $day." at ".$time;
	

	$user_data = array("webinar_id" => intval($_POST['webinar_id']),
						"mop" => $_POST['mop'],
						"pop" => $_POST['pop'],
						"status" => "In-Process",
						"date_applied"=>$date_applied
						);

	if($db->insertWebinar($_POST['email'], $user_data)){
		$response['error'] = false;
		$response['message'] = "Registered successfully. Please wait for the confirmation. Thank you.";
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