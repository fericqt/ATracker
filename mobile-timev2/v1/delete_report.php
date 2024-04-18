<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	if($db->deleteReport((int)$_POST['report_ID'])){
		$response['error'] = false;
		$response['message'] = "Report has been deleted.";
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