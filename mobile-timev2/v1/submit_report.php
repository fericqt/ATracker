<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$email = $_POST['email'];
	date_default_timezone_set('Asia/Manila');
	$date = date('F d, Y');
	$time = date('g:i A');
	$dt = $date." at ".$time;

	$user_data = array("ticket_no"=>$_POST['ticket_no'],
						"report_subject" => $_POST['report_title'],
						"report_details" => $_POST['report_details'],
						"gdrive_link"=>$_POST['gdrive_link'],
						"report_status" => "Pending",
						"date_submitted" => $dt);

	$insert_data = $db->insertReport($email, $user_data);
	if($insert_data){
		$response['error'] = false;
		$response['message'] = "Data has successfully added.";
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