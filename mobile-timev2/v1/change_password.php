<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

	$db = new DBOperations();

	date_default_timezone_set("Asia/Manila");
	$user_data = $db->getUserID($_POST['email']);
	$date_today = date('Y-m-d');

	if($user_data['password_updated'] == $date_today){
		$response['error'] = true;
		$response['message'] = "Password reset limit. You can only request new password once every day. Please wait tomorrow.";
	}else{
		if($_POST['old_password'] != "" && $_POST['new_password'] != "" && $_POST['confirm_password'] != ""){
			if($db->verifyOldPassword($_POST['email'], $_POST['old_password'])){
				if($_POST['new_password'] == $_POST['confirm_password']){
					$update_password = $db->changePassword($_POST['email'], $_POST['new_password']);

					if($update_password == 1){
						$response['error'] = true;
						$response['message'] = "DB: Something went wrong.";
					}else{
						$response['message'] = "Password change successfully.";
						$response['error'] = false;
					}

				}else{
					$response['error'] = true;
					$response['message'] = "Confirm password did not match to new password.";
				}

			}else{
				$response['error'] = true;
				$response['message'] = "Old password did not match.";
			}

		}else{
			$response['error'] = true;
			$response['message'] = "Required fields are missing.";
		}
	}
	

}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);
?>