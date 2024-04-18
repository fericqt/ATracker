<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');

	$date_assigned = new DateTime($_POST['date_assigned']);
	$date_assigned = $date_assigned->format('Y-m-d');


	$user_input = array("task_name" => $_POST['task_name'],
						"file_format"=>$_POST['file_format'],
						"date_assigned"=>$_POST['date_assigned'],
						"date_updated"=>$date,
						"gdrive_link"=>$_POST['gdrive_link']);

	if($db->updateProjectStatus((int)$_POST['project_status_ID'], $user_input)){
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