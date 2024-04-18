<?php

    $user_acc_id = $_GET['id']; 
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM team, user_acc, team_project where team.co_leader_id=user_acc.user_acc_id AND team_project.team_name=team.team_name  AND team.co_leader_id='".$user_acc_id."'";
    
    $result = $conn->query($sql);

    

    if ($result->num_rows > 0) {
      
      $response['data'] = array();

      // output data of each row
      
      while($row = $result->fetch_array()) {

        $date_assigned = $row['date_assigned'];   
        $date_assigned1 = date('F d, Y ', strtotime($date_assigned));

        $date_submitted = $row['date_submitted'];   
        $date_submitted1 = date('F d, Y ', strtotime($date_submitted));

            $sql1 = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.co_leader_id='".$row["co_leader_id"]."'";
    
            $result1 = $conn->query($sql1);
    
    
                while($row1 = $result1->fetch_array()) {
                $view_team_project = array();
                $view_team_project["ID"] = $row["team_project_id"];
                $view_team_project["Team Name"] = $row1["team_name"];
                $view_team_project["Team Leader"] = $row1["firstname"]." ".$row1["middle_name"]." ".$row1["lastname"];
                $view_team_project["Co Leader"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
                $view_team_project["Task Name"] = $row["task_name"];
                $view_team_project["File Format"] = $row["file_formats"];
                $view_team_project["Date Assigned"] = $date_assigned1;
                $view_team_project["Date Submitted"] = $date_submitted1;
                $view_team_project["G-Drive Link"] = "<a href=".$row["gdrive_link"]." target='_blank' style='text-decoration: none'>G-DRIVE LINK</a>";
                
                
                array_push($response['data'], $view_team_project);
        

       
        }

    }
      echo json_encode($response);  

      
    } else {
      echo json_encode(array('data'=>''));
    }


    $conn->close();
?>