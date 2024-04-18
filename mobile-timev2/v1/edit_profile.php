<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$email = $_POST['user_email'];

	$user_data = array("street" => $_POST['street'], 
						"barangay" => $_POST['barangay'],
						"city" => $_POST['city'],
						"province"=>$_POST['province'],
						"email" => $_POST['email'],
						"contact_number" => $_POST['contact_number'],
						"drive" => $_POST['drive']);

	$update_data = $db->updateUserProfile($email, $user_data);

	if($update_data == 1){
		$response['error'] = true;
		$response['message'] = "DB: Something went wrong.";
	}else{
		$response['error'] = false;
		$response['message'] = "Data has been updated successfully";
	}



}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>