<?php
	
	include("db/dbconnection.php");
    
    $permission = 0;
    $sql = "SELECT * FROM user_acc, intern_info where  intern_info.username=user_acc.username AND user_acc.usertype='Intern' AND user_acc.permission='".$permission."'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $view_permission = array();
		  $view_permission["User ID"] = $row["user_acc_id"];
      $view_permission["Intern ID"] = $row["intern_info_id"];
          $view_permission["Application ID"] =  $row["app_id"];
          $view_permission["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];	  
		  
          array_push($response['data'], $view_permission);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>