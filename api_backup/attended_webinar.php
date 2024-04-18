<?php


	include("db/dbconnection.php");
	


        $user_acc_id = $_POST['user_acc_id'];
        $web_id = $_POST['web_id'];
        $mode_of_payment = $_POST['payment'];
        $screenshot = $_POST['screenshot'];
        $status = 'In-Process';

		$sql = "SELECT * FROM attended_webinar  WHERE webinar_id='".$web_id."' AND user_acc_id='".$user_acc_id."'";
			$result = $conn->query($sql);
			
			if(mysqli_num_rows($result)>0)
			{
				echo '2';
			}
			else
			{
		
	            $sql1 = "INSERT INTO attended_webinar (webinar_id, user_acc_id, mode_of_payment, screenshot, status_payment) VALUES ('$web_id', '$user_acc_id', '$mode_of_payment', '$screenshot', '$status')";
				if ($conn->query($sql1) === TRUE) 
				{
					echo "1" ;			
			
				} else 
				{
					echo "0";
				}
			}
			
        
        $conn->close();
   
	

?>