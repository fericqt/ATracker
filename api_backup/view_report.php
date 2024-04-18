<?php
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM intern_report, user_acc where intern_report.user_acc_id=user_acc.user_acc_id";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $view_report = array();
		  $view_report["ID"] = $row["report_id"];
          $view_report["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
		  $view_report["Title Name"] = $row["report_subject"];
          $view_report["Files"] = "<a href=".$row["gdrive_link"]." target='_blank' style='text-decoration: none'>G-DRIVE LINK</a>";
		  
		  
          array_push($response['data'], $view_report);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>