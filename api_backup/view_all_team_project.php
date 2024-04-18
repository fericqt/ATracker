<?php
	$id = $_GET['id']; 

    
	include("db/dbconnection.php");
    
    
   
    $sql = "SELECT * FROM user_acc, team_project, team where user_acc.user_acc_id=team_project.user_acc_id AND user_acc.user_acc_id=team.leader_id AND team_project.user_acc_id='".$id."'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $view_project = array();
		  $view_project["ID"] = $row["team_project_id"];
          $view_project["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
          $view_project["Team Name"] = $row["team_name"];
          $view_project["Task Name"] = $row["task_name"];
          $view_project["Date Assigned"] = $row["date_assigned"];
          $view_project["Date Submitted"] = $row["date_submitted"];
          $view_project["File Format"] = $row["file_formats"];
          $view_project["G-Drive Link"] =  "<a href=".$row["gdrive_link"]." target='_blank' style='text-decoration: none'>G-DRIVE LINK</a>";
		  
		  
          array_push($response['data'], $view_project);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>