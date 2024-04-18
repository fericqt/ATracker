<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$user_input = array("report_title" => $_POST['report_title'],
						"report_details"=>$_POST['report_details'],
						"report_documents"=>$_POST['report_documents']);

	if($db->updateReport((int)$_POST['report_ID'], $user_input)){
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