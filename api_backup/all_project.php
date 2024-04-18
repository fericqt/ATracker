<?php
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM user_acc, intern_info where user_acc.username=intern_info.username AND user_acc.usertype='Intern'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $all_project = array();
		  $all_project["ID"] = $row["user_acc_id"];
          $all_project["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
		  $all_project["Department"] = $row["department"];
		  $all_project["Company"] = $row["company"];
		  
		  
          array_push($response['data'], $all_project);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>