<?php
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id";
    
    $result = $conn->query($sql);

    

    if ($result->num_rows > 0) {
      
      $response['data'] = array();

      // output data of each row
      
      while($row = $result->fetch_array()) {

        if($row["co_leader_id"]==0)
        {

            $view_team = array();
            $view_team["ID"] = $row["leader_id"];
            $view_team["Team Name"] = $row["team_name"];
            $view_team["Team Leader"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
            $view_team["Co Leader"] = "<label class='badge badge-info'><strong>NO CO LEADER</strong></label>";
            
            
            array_push($response['data'], $view_team);
        }else{
            $sql1 = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id AND team.leader_id='".$row["user_acc_id"]."'";
    
            $result1 = $conn->query($sql1);
    
    
                while($row1 = $result1->fetch_array()) {
                $view_team = array();
                $view_team["ID"] = $row1["leader_id"];
                $view_team["Team Name"] = $row1["team_name"];
                $view_team["Team Leader"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
                $view_team["Co Leader"] = $row1["firstname"]." ".$row1["middle_name"]." ".$row1["lastname"];
                
                
                array_push($response['data'], $view_team);
        }

       
        }

    }
      echo json_encode($response);  

      
    } else {
      echo json_encode(array('data'=>''));
    }


    $conn->close();
?>