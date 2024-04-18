<?php
    header("Content-Type: application/json; charset=UTF-8");

    include("db/dbconnection.php");
	
	$email = $_GET['email'];
	
    $sql = "SELECT * FROM intern_info WHERE username = '$email'";
    $result = $conn->query($sql);
    
    $response = array();
    
    if ($result->num_rows > 0) {

	  if($row = $result->fetch_assoc()) {
			
			if($row["start_shift"] == "8:00 AM"){
				
				echo '1';
				
			}else if($row["start_shift"] == "9:00 AM"){
				
				echo '2';
				
			}else{
				
				echo '3';
				
			}			
	  }

	} 
	$conn->close();
	
?>