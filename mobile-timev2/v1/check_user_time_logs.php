<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	$result = $db->checkUserTimeLogs($_POST['email']);
	if($result == 1){
		$response['error'] = false;
		$response['message'] = "";
		$response['btn_status'] = 0;
		$response['last_id'] = 0;
	}else if($result['date_out'] == "0000-00-00"){
		$response['error'] = false;
		$response['message'] = "";
		$response['btn_status'] = 0;
		$response['last_id'] = 0;
		
	}else{
		if($result['date_out'] == null || $result['date_out'] == ""){

			$response['error'] = false;
			$response['message'] = "";
			$response['btn_status'] = 1;
			$response['last_id'] = $result['att_id'];

		}else{
			$response['error'] = false;
			$response['message'] = "";
			$response['btn_status'] = 2;
			$response['last_id'] = 0;
		}
	}

}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>