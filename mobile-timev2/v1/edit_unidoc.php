<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');

	$date_assigned = new DateTime($_POST['date_submitted']);
	$date_assigned = $date_assigned->format('Y-m-d');


	$user_input = array("document_title" => $_POST['document_title'],
						"coordinator_name" => $_POST['coordinator_name'],
						"coordinator_email" => $_POST['coordinator_email'],
						"file_format"=>$_POST['file_format'],
						"date_submitted"=>$_POST['date_submitted'],
						"date_updated"=>$date,
						"deadline"=>$deadline,
						"gdrive_link"=>$_POST['gdrive_link']);

	if($db->updateUniDocStatus((int)$_POST['document_id'], $user_input)){
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