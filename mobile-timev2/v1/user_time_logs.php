<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

	$db = new DBOperations();

	if($_POST['btnName'] == "TIME-IN"){
		$timeIn = $db->userTimeIn($_POST['email'], $_POST['start_time'], $_POST['company'], intval($_POST['required_hours']));
		if($timeIn == "no_shift"){
			$response['error'] = true;
			$response['message'] = "You don't have shift today according to your schedule.";
			$response['btnText'] = "TIME-IN";
		}else if($timeIn == "early"){
			$response['error'] = true;
			$response['message'] = "You can only time-in 15mins before your shift.";
			$response['btnText'] = "TIME-IN";

		}else if($timeIn == "late"){
			$newTimeIn = $db->lateTimeIn($_POST['email'], $_POST['company'], intval($_POST['required_hours']));
			$response['error'] = false;
			$response['message'] = "Time in successfully.";
			$response['btnText'] = "ATTENDANCE COMPLETED";
			$response['last_id'] = 0;
			
		}else if($timeIn == false){
			$response['error'] = true;
			$response['message'] = "DB: Something went wrong.";
			$response['btnText'] = "TIME-IN";

		}else if($timeIn == "offboard"){
			$response['error'] = true;
			$response['message'] = "You are already offboard. You won't be able to time-in now.";
			$response['btnText'] = "TIME-IN";
		}else{
			$response['error'] = false;
			$response['message'] = "Time in successfully.";
			$response['btnText'] = "TIME-OUT";
			$response['last_id'] = $timeIn;
		}
	}else{
		$timeOut = $db->userTimeOut($_POST['email'], intval($_POST['last_id']), $_POST['end_time'], intval($_POST['required_hours']));

		if($timeOut == 0){
			$response['error'] = true;
			$response['message'] = "Time has already exceeded 25mins from your end of shift. You cannot time-out today. Please be responsible next time.";
		}else{

			if($timeOut){
			$response['error'] = false;
			$response['message'] = "You have time-out successfully.";
			
			}else{
				$response['error'] = true;
				$response['message'] = "DB: Something went wrong.";
			}
		}

		
	}

}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);
?>