<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$email = $_POST['email'];
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	$date_assigned = new DateTime($_POST['date_assigned']);
	$date_assigned = $date_assigned->format('Y-m-d');

	$user_data = array("document_title" => $_POST['document_title'],
						"coordinator_name" => $_POST['coordinator_name'],
						"coordinator_email" => $_POST['coordinator_email'],
						"file_format" => $_POST['file_format'],
						"date_submitted" => $date, 
						"deadline"=>$deadline,
						"status"=>"Pending",
						"gdrive_link" => $_POST['gdrive_link']);

	$insert_data = $db->insertUniDocStatus($email, $user_data);
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