<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$user_data = $db->getUserData($_POST['email']);
	$user_info = $db->getUserBasicInfo($_POST['email']);
	$remaining_hrs = $db->getRemainingHours($_POST['email']);
	$remaining_hrs = $remaining_hrs['hrs_left'];
	$rendered_hrs = $user_info['required_hours'] - $remaining_hrs;

	$response['error'] = false;
	$response['message']= "";

	$response['application_id'] = $user_info['app_id'];
	$response['first_name'] = $user_data['firstname'];
	$response['last_name'] = $user_data['lastname'];
	$response['email'] = $_POST['email'];
	$response['contact_number'] = $user_info['mobile_no'];
	$response['street'] = $user_info['street'];
	$response['barangay'] = $user_info['barangay'];
	$response['city'] = $user_info['city'];
	$response['province'] = $user_info['province'];
	$response['address1'] = $user_info['street'].", ".$user_info['barangay'];
	$response['address2'] = $user_info['city'] . ", " . $user_info['province'];
	$response['birthdate'] = date("F d, Y", strtotime($user_info['birthdate']));
	$response['gender'] = $user_info['sex'];
	$response['department'] = $user_info['department'];
	$response['drive'] = $user_info['gdrive_link'];
	$response['image'] = $user_data['profile_pic'];
	$response['rendered_hrs'] = $rendered_hrs;
	$response['remaining_hrs'] = $remaining_hrs;


}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>