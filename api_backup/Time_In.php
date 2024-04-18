<?php

  header('Access-Control-Allow-Origin: *');

  include('db/dbconnection.php');
  
  
 if(isset($_POST['email'])){
   
   date_default_timezone_set('Asia/Singapore');
	$email = $_POST['email'];
	$user_id = "";
	$remark = "Time in Successful";
	$currentTime = date('H:i');
	$currentDate = date('Y-m-d');	
		
    $sql = "SELECT * FROM user_acc WHERE username = '$email'";
    
	$result = $conn->query($sql);
    
    $response = array();
    
    if ($result->num_rows > 0) {

	  if($row = $result->fetch_assoc()) {
		$user_id = $row["user_acc_id"];;
	  }
	}   

	
	$sql5 = "SELECT MIN(hrs_left) AS hrs_left FROM attendance WHERE user_acc_id = '$user_id'";
    
	$result5 = mysqli_query($conn, $sql5);
    $row5 = $result5->fetch_assoc();
    $hrs_left = $row5["hrs_left"];
	$rqrd_hrs=0;
	$add_hrs=0;
	
	if($hrs_left == 0)
	{
		$sql4 = "SELECT * FROM intern_info WHERE username = '$email'";
    
		$result4 = $conn->query($sql4);
    
		$response = array();
    
		if ($result4->num_rows > 0) {

			if($row4 = $result4->fetch_assoc()) {
				$add_hrs = $row4["added_hours"];
				if($add_hrs == 0)
				{
					$rqrd_hrs = $row4["required_hours"];
				}
				else{
					$rqrd_hrs = $row4["required_hours"] - $add_hrs; 
			
				}
			}
		} 		
	}else{
		$rqrd_hrs=$hrs_left;
	}
	

    $sql7 = "SELECT * FROM attendance WHERE date_in='$currentDate' AND user_acc_id = '$user_id' ";
    
    $result7 = $conn->query($sql7);
	
	$row7 = mysqli_num_rows($result7);
	if($row7 > 0)
	{
	   array_push($response, "Failed");
	}else
	{
	
	if($currentTime > "08:15" && $currentTime <= "08:30")
	{
		$remark1 = "1 hr late";
		$one_hr_late_time_in = "09:00";
		$sql2 = "INSERT INTO attendance (user_acc_id, date_in, time_in, date_out, time_out, hrs_today,remark_time_in, remark) VALUES ('$user_id','$currentDate','$one_hr_late_time_in','','',0,'$remark1','$remark')";

	}else if($currentTime >= "08:31" && $currentTime <= "10:00")
	{
		$remark1 = "2 hrs late";
		$two_hr_late_time_in = "10:00";
		$sql2 = "INSERT INTO attendance (user_acc_id, date_in, time_in, date_out, time_out, hrs_today,remark_time_in, remark) VALUES ('$user_id','$currentDate','$two_hr_late_time_in','','',0,'$remark1','$remark')";

	}else if($currentTime <= "08:15" && $currentTime >= "07:45")
	{
		$remark1 = "On time";
		$on_time = $currentTime;
		$sql2 = "INSERT INTO attendance (user_acc_id, date_in, time_in, date_out, time_out, hrs_today,remark_time_in, remark) VALUES ('$user_id','$currentDate','$on_time','','',0,'$remark1','$remark')";

	}else{
		$remark1 = "Very late (Absent)";
		$absent_time_in = $currentTime;
		$absent_time_out = $currentTime;		
		$sql2 = "INSERT INTO attendance (user_acc_id, date_in, time_in, date_out, time_out, hrs_today,remark_time_in, remark, hrs_added, hrs_left) VALUES ('$user_id','$currentDate','$absent_time_in','$currentDate','$absent_time_out',0,'$remark1','Time out Successful',0,'$rqrd_hrs')";
	}

    if ($conn->query($sql2) === TRUE) {
      array_push($response, "Success");
    

    } else {
      echo $conn -> error;
    }
	}
    
    $conn->close();
 }
?>
 