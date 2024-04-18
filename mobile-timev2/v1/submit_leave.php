<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$email = $_POST['email'];
	date_default_timezone_set('Asia/Manila');
	$start_date = new DateTime($_POST['date_start']);
	$start_date = $start_date->format('Y-m-d');

	$end_date = new DateTime($_POST['date_end']);
	$end_date = $end_date->format('Y-m-d');	

	$user_data = array("leave_reason" => $_POST['leave_reason'],
						"leave_reason_details"=>$_POST['leave_reason_details'],
						"date_start"=>$start_date,
						"date_end"=>$end_date,
						"leave_status"=>"Pending");

	$insert_data = $db->insertLeave($email, $user_data);
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