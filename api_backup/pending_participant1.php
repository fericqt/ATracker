<?php
	
    $id = (int)$_GET['id']; 
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM user_acc, attended_webinar, webinar where user_acc.user_acc_id=attended_webinar.user_acc_id AND attended_webinar.webinar_id=webinar.webinar_id AND attended_webinar.status_payment='Verified' AND user_acc.usertype='Intern' AND attended_webinar.webinar_id='".$id."'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $view_participant = array();
		  $view_participant["ID"] = $row["attend_web_id"];
      $view_participant["Participant"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
		  $view_participant["Title"] = $row["title_name"];
      $view_participant["Mode of Payment"] = $row["mode_of_payment"];
      $view_participant["Proof of Payment"] = "<a href=".$row["screenshot"]." target='_blank' style='text-decoration: none'>G-DRIVE LINK</a>";
		  
		  
          array_push($response['data'], $view_participant);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>