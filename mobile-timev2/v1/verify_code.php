<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if($_POST['code'] != ""){
		$db = new DBOperations();

		$delete_data = $db->deleteUserVerificationData($_POST['email']);
		if($delete_data == 1){
			$response['error'] = true;
			$response['message'] = "DB: Something went wrong.";
		}else{
			$response['error'] = false;
			$response['message'] = "Data deleted.";
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Required fields are missing.";
	}
}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}


echo json_encode($response);

?>