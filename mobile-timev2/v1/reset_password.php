<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if($_POST['password'] != ""){
		$db = new DBOperations();
		$change_password = $db->changePassword($_POST['email'], $_POST['password']);

		if($change_password == 1){
			$response['error'] = true;
			$response['message'] = "DB: Something went wrong.";
		}else{
			$response['message'] = "Password change successfully.";
			$response['error'] = false;
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