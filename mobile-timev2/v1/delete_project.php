<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	if($db->deleteProjectStatus((int)$_POST['project_status_ID'])){
		$response['error'] = false;
		$response['message'] = "Project has been deleted.";
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