<?php
	$user_acc_id = $_GET['id']; 

    
	include("db/dbconnection.php");
    
    
   
    $sql = "SELECT * FROM user_acc, project where user_acc.user_acc_id=project.user_acc_id AND user_acc.user_acc_id='".$user_acc_id."' AND project.user_acc_id='".$user_acc_id."'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
        $date_assigned = $row['date_assigned'];   
        $date_assigned1 = date('F d, Y ', strtotime($date_assigned));
        $date_submitted = $row['date_submitted'];   
        $date_submitted1 = date('F d, Y ', strtotime($date_submitted));

		  $view_project = array();
		  $view_project["ID"] = $row["project_id"];
          $view_project["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
          $view_project["Task Name"] = $row["task_name"];
          $view_project["Date Assigned"] = $date_assigned1;
          $view_project["Date Submitted"] = $date_submitted1;
          $view_project["File Format"] = $row["file_formats"];
          $view_project["G-Drive Link"] = "<a href=".$row["gdrive_link"]." target='_blank' style='text-decoration: none'>G-DRIVE LINK</a>"; 
		  
		  
          array_push($response['data'], $view_project);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>