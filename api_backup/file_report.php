<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['user_acc_id']) && isset($_POST['report_subject']) && isset($_POST['report_details']) && isset($_POST['report_files'])){

        $user_acc_id = $_POST['user_acc_id'];
        $report_subject = $_POST['report_subject'];
		$report_details = $_POST['report_details'];
        $report_files = $_POST['report_files'];
		$report_status = 'Pending';

		
		
	            $sql1 = "INSERT INTO intern_report (user_acc_id, report_subject, report_details, gdrive_link, report_status) VALUES ('$user_acc_id', '$report_subject', '$report_details', '$report_files', '$report_status')";
				if ($conn->query($sql1) === TRUE) 
				{
					echo "1" ;			
			
				} else 
				{
					echo "0";
				}
			
        
        $conn->close();
    }
	

?>