<?php
	$user_acc_id = $_GET['id']; 

    
	include("db/dbconnection.php");
    
    
   
    $sql = "SELECT * FROM user_acc, attended_webinar, webinar where user_acc.user_acc_id=attended_webinar.user_acc_id AND webinar.webinar_id=attended_webinar.webinar_id AND attended_webinar.user_acc_id='".$user_acc_id."'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {

		  $view_web = array();
		
          $view_web["Participant"] =  $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
          $view_web["Title"] = $row["title_name"];
          $view_web["Status"] = $row["status_payment"];
  
		  
		  
          array_push($response['data'], $view_web);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>