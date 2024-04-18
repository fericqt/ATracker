<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	if($_POST['search'] != ""){
		$response = $db->getUniDocStatusBySearch($_POST['email'], $_POST['search'], $_POST['filter']);
	}else{
		$response = $db->getUniDocStatus($_POST['email'], $_POST['filter']);
	}
	
}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);
?>