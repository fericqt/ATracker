<?php

    $user_acc_id = $_GET['id']; 
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM team, user_acc, weekly_report where team.co_leader_id=user_acc.user_acc_id AND weekly_report.team_name=team.team_name  AND team.co_leader_id='".$user_acc_id."'";
    
    $result = $conn->query($sql);

    

    if ($result->num_rows > 0) {
      
      $response['data'] = array();

      // output data of each row
      
      while($row = $result->fetch_array()) {

        $date_submitted = $row['date_submitted'];   
        $date_submitted1 = date('F d, Y ', strtotime($date_submitted));

            $sql1 = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.co_leader_id='".$row["co_leader_id"]."'";
    
            $result1 = $conn->query($sql1);
    
    
                while($row1 = $result1->fetch_array()) {
                $view_weekly_report = array();
                $view_weekly_report["ID"] = $row["weekly_report_id"];
                $view_weekly_report["Team Name"] = $row1["team_name"];
                $view_weekly_report["Team Leader"] = $row1["firstname"]." ".$row1["middle_name"]." ".$row1["lastname"];
                $view_weekly_report["Co Leader"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
                $view_weekly_report["Week #"] = $row["weekly_no"];
                $view_weekly_report["Date Submitted"] = $date_submitted1;

                if($row["report_status"] == 'Signed'){
                    $view_weekly_report["Status"] = "<label class='badge badge-light' style='color:#000000'><strong>".$row["report_status"]."</strong></label>";
                }else{
                    $view_weekly_report["Status"] = "<label class='badge badge-light' style='color:#D96876'><strong>".$row["report_status"]."</strong></label>";
                }
                
                
                
                array_push($response['data'], $view_weekly_report);
        

       
        }

    }
      echo json_encode($response);  

      
    } else {
      echo json_encode(array('data'=>''));
    }


    $conn->close();
?>