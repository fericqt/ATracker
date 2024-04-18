<?php
		
	date_default_timezone_set('Asia/Manila');
	   
    include("db/dbconnection.php");
	
 if(isset($_POST['email'])){
   
	$email = $_POST['email'];
	$currentDate = date('Y-m-d');
	$currentTime = date('H:i');
	$remark="Time in Successful";
	$lastID="";
	$user_id="";
	$time_in="";
	
    $sql = "SELECT * FROM user_acc WHERE username = '$email'";
    
	$result = $conn->query($sql);
    
    $response = array();
    
    if ($result->num_rows > 0) {

	  if($row = $result->fetch_assoc()) {
		$user_id = $row["user_acc_id"];
	  }
	}  
	
	$result1 = mysqli_query($conn, "SELECT MAX(att_id) AS id FROM attendance WHERE user_acc_id = '$user_id'"); 
	
	while($row1=mysqli_fetch_assoc($result1)){
		$lastID = $row1['id'];
	}

    $sql3 = "SELECT * FROM attendance WHERE att_id = '$lastID' AND user_acc_id = '$user_id'";
    
	$result3 = $conn->query($sql3);
    
    $response = array();
    
    if ($result3->num_rows > 0) {

	  if($row3 = $result3->fetch_assoc()) {
		$time_in = $row3["time_in"];
	  }
	} 
	
	$today_hrs3 = round((strtotime("12:00") - strtotime($time_in))/3600, 1);
	$today_hrs2 = round((strtotime($currentTime) - strtotime("13:00"))/3600, 1);
	
	$today_hrs1 = $today_hrs3 + $today_hrs2;
	
	if($today_hrs1 > 8 ){
		$today_hrs = 8;
	}else{
		$today_hrs = $today_hrs1;
	}
	$rqrd_hrs=0;
	$add_hrs=0;
	
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
	
	 
	
    $sql2 = "UPDATE attendance SET time_out = '$currentTime' , date_out = '$currentDate' , remark = 'Time out Successful', hrs_today = '$today_hrs' WHERE remark='$remark' and att_id='$lastID' and user_acc_id ='$user_id'";
    
	if (mysqli_query($conn, $sql2)) {
		
		$sql5 = "SELECT SUM(hrs_today) AS hrs_added FROM attendance WHERE user_acc_id = '$user_id'";
    
		$result5 = mysqli_query($conn, $sql5);
        $row5 = $result5->fetch_assoc();
        $hrs_added = $row5["hrs_added"];
		
		
		$hrs_left = $rqrd_hrs - $hrs_added;
		
		$sql6 = "UPDATE attendance SET hrs_left = '$hrs_left', hrs_added = '$hrs_added' WHERE remark='Time out Successful' and att_id='$lastID' and user_acc_id ='$user_id'";
	
		if (mysqli_query($conn, $sql6)) {
	
			echo "Record updated successfully";
		}			

	} else {
  
	echo "Error updating record: " . mysqli_error($conn);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 }
	 $conn->close();
?>