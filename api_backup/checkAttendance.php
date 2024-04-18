<?php
		
	date_default_timezone_set('Asia/Manila');
	   
    include("db/dbconnection.php");
	
	$id = $_GET['id'];
	
	$currentDate = date('Y-m-d');
	$currentTime = date('h:i A');
	$remark="Time in Successful";
	$lastID="";

    $sql = "SELECT * FROM user_acc WHERE username = '$id'";
    
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
	
    $sql = "SELECT * FROM attendance WHERE remark='$remark' and att_id='$lastID' and user_acc_id = '$user_id' and date_in ='$currentDate'";
    
    $result2 = $conn->query($sql);
	
	$row2 = mysqli_num_rows($result2);


    $sql2 = "SELECT * FROM attendance WHERE remark='Time out Successful' and att_id='$lastID' and user_acc_id = '$user_id' and date_out = '$currentDate'";
    
    $result3 = $conn->query($sql2);
	
	$row3 = mysqli_num_rows($result3);
	
	if($row2 > 0)
	{
	   echo '1';
	}
	else
	{
		if($row3 > 0)
		{
			echo '3';
		}else{
			
			echo '0';
		}
	}
?>