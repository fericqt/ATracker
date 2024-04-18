<?php
date_default_timezone_set('Asia/Manila');
$response = array();

if($_SERVER['REQUEST_METHOD']=='GET'){
	$response['error'] = false;
	$date = date("F j, Y");
	$day = date("l");
	$time = date("h:i:sa");

	$response['date'] = $date;
	$response['day'] = $day;
	$response['time'] = $time;


}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}


echo json_encode($response);


?>