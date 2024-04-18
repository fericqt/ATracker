<?php

	include("db/dbconnection.php");
	
    $id = $_POST['id'];
    $report_status = 'Signed';
    
   $sql = "UPDATE weekly_report SET report_status='$report_status' where weekly_report_id='$id'";
    
		
		if ($conn->query($sql) === TRUE) {
			echo "1";
		}
		else {
		  echo "0";
		}
     
    
    $conn->close();
?>