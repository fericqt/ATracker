<?php

	include("db/dbconnection.php");
	
  
    
    
    if(isset($_POST['tean_name']) && isset($_POST['team_id'])){

        $tean_name = $_POST['tean_name'];
        $team_id = $_POST['team_id'];	
        $co_lead = 0;
        $position = 1;	

        $sql = "SELECT * FROM team WHERE team_name='".$_POST['tean_name']."'";
        $result = $conn->query($sql);
        
        if(mysqli_num_rows($result)!=0)
        {
          echo '2';
        }
        else
        {
              $sql1 = "INSERT INTO team (leader_id, co_leader_id, team_name) VALUES ('$team_id', '$co_lead', '$tean_name')";
              if ($conn->query($sql1) === TRUE) 
              {
                $sql = "UPDATE user_acc SET position='$position' where user_acc_id='$team_id'";

                              if ($conn->query($sql) === TRUE) {
                              echo "1";
                              } else {
                              echo "2";
                              }			
            
              } else 
              {
                echo "0";
              }
			
        }
        
        $conn->close();
    }
	
?>