<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['user_acc_id']) && isset($_POST['task_name']) && isset($_POST['date_assigned']) && isset($_POST['file_formats']) && isset($_POST['gdrive_link']) && isset($_POST['team_name'])){

		$team_name = $_POST['team_name'];
        $user_acc_id = $_POST['user_acc_id'];
		$task_name = $_POST['task_name'];
        $date_assigned = $_POST['date_assigned'];
		$file_formats = $_POST['file_formats'];
		$gdrive_link = $_POST['gdrive_link'];
        $now = date_create()->format('Y-m-d');
		
		
	            $sql1 = "INSERT INTO team_project (user_acc_id, task_name, date_assigned, date_submitted, file_formats, team_name, gdrive_link) VALUES ('$user_acc_id', '$task_name', '$date_assigned', '$now', '$file_formats','$team_name', '$gdrive_link')";
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