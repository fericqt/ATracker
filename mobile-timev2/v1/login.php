<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	if($_POST['email'] != "" || $_POST['password'] !=""){
		$result = $db->loginUser($_POST['email'], $_POST['password']);
		if($result == 8){
			$response['error'] = true;
			$response['message'] = "Invalid email address.";
		}else if($result == 7){
			$response['error'] = true;
			$response['message'] = "User does not exist.";
		}else if($result == 6){
			$response['error'] = true;
			$response['message'] = "Sorry, your application has been rejected. Please apply again using different email.";

		}else if($result == 5){
			$response['error'] = true;
			$response['message'] = "Your application is still pending. Please wait for the approval of the admin. Thank you.";
		}else if($result == 4){
			$response['error'] = true;
			$response['message'] = "Only an intern can login using this mobile app. Please use the Attendance Tracker V2 web to login.";

		}else if($result == 3){
			$response['error'] = true;
			$response['message'] = "You have been terminated in the UIP. You cannot login now.";

		}else if($result == 2){
			$response['error'] = true;
			$response['message'] = "You have already completed your internship with your company.";

		}else if($result == 1){
			$response['error'] = true;
			$response['message'] = "Username or password is incorrect.";
		}else{
			$user_data = $db->getUserData($_POST['email']);
			$user_info = $db->getUserBasicInfo($_POST['email']);
			$response['error'] = false;
			$response['message'] = "You have logged-in successfully.";
			$response['firstname'] = $user_data['firstname'];
			$response['lastname'] = $user_data['lastname'];
			$response['middle_name'] = $user_data['middle_name'];
			$response['position'] = $user_data['position'];
			$response['school'] = $user_info['school'];
			$response['company'] = $user_info['company'];
			$response['department'] = $user_info['department'];
			$response['start_shift'] = $user_info['start_shift'];
			$response['end_shift'] = $user_info['end_shift'];
			$response['required_hours'] = $user_info['required_hours'];
			
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