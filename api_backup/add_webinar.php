<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['registration_fee']) && isset($_POST['user_acc_id']) && isset($_POST['webinar_title']) && isset($_POST['webinar_desc']) && isset($_POST['webinar_link']) && isset($_POST['speaker']) && isset($_POST['webinar_date'])){

		$user_acc_id = $_POST['user_acc_id'];
        $webinar_title = $_POST['webinar_title'];
        $webinar_desc = $_POST['webinar_desc'];
		$webinar_link = $_POST['webinar_link'];
        $speaker = $_POST['speaker'];
		$registration_fee = $_POST['registration_fee'];
		$webinar_date = $_POST['webinar_date'];
		$webinar_time = $_POST['webinar_time'];
		$web_status = '0';
        $now = date_create()->format('Y-m-d');

		$time_in_12_hour_format  = date("g:i a", strtotime($webinar_time));
		
				$sql1 = "INSERT INTO webinar (user_acc_id,title_name, webinar_desc, meeting_link, speaker, meeting_date, meeting_time, registration_fee, date_posted, web_status) VALUES ('$user_acc_id','$webinar_title', '$webinar_desc', '$webinar_link', '$speaker', '$webinar_date', '$time_in_12_hour_format', '$registration_fee', '$now', '$web_status')";
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