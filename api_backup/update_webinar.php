<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['registration_fee']) && isset($_POST['user_acc_id']) && isset($_POST['webinar_id']) && isset($_POST['webinar_title']) && isset($_POST['webinar_desc']) && isset($_POST['webinar_link']) && isset($_POST['speaker']) && isset($_POST['webinar_date']) && isset($_POST['webinar_time'])){

		$user_acc_id = $_POST['user_acc_id'];
        $webinar_id = $_POST['webinar_id'];
        $webinar_title = $_POST['webinar_title'];
        $webinar_desc = $_POST['webinar_desc'];
		$webinar_link = $_POST['webinar_link'];
        $speaker = $_POST['speaker'];
		$registration_fee = $_POST['registration_fee'];
		$webinar_date = $_POST['webinar_date'];
		$webinar_time = $_POST['webinar_time'];
        $now = date_create()->format('Y-m-d');

		
        $sql1 = "UPDATE webinar SET user_acc_id='$user_acc_id', title_name='$webinar_title', webinar_desc='$webinar_desc', meeting_link='$webinar_link', speaker='$speaker', meeting_date='$webinar_date', meeting_time='$webinar_time', registration_fee='$registration_fee', date_posted='$now' where webinar_id='$webinar_id'";
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