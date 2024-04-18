<?php
require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();

	if($db->deleteUniDocStatus((int)$_POST['document_id'])){
		$response['error'] = false;
		$response['message'] = "Document has been deleted.";
	}else{
		$response['error'] = true;
		$response['message'] = "DB: Something went wrong.";
	}


}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>