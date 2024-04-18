<?php
	
    $user_acc_id = $_GET['id'];  

	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.leader_id='$user_acc_id.'";
    
    $result = $conn->query($sql);
	$team_name = "";
	$user_id = "";
	$leader_name = "";
	$co_lead_name="";
	$team_id ="";
    
    if ($result->num_rows > 0) {
    
      
      while($row = $result->fetch_array()) 
      {
		$user_id = $row["user_acc_id"];
		$leader_name = $row["firstname"];
		$leader_last_name = $row["lastname"];
		$profile_pic_lead = $row["profile_pic"];
      }       

      
    }
	
    $sql1 = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id AND team.leader_id= '$user_id'";
    
    $result1 = $conn->query($sql1);	
	
    if ($result1->num_rows > 0) {
    
      
      while($row1 = $result1->fetch_array()) 
      {
		$team_name = $row1["team_name"];
		$co_lead_name = $row1["firstname"];
		$co_lead_last_name = $row1["lastname"];
		$team_id = $row1["team_id"];
		$profile_pic_co_lead = $row1["profile_pic"];
      }       
     
    }	
            echo '<div class="row">';
              echo '<div class="col-md-12 stretch-card grid-margin" >';
                echo '<div class="card card-img-holder text-white " style="background-color:#000" >';
                  echo '<div class="card-body">';
                    echo '<center><div style="margin:auto">';
					echo '<h1 class="font-weight-normal mb-3">'.$team_name.'</h1>';
					echo '</div></center>';
                  echo '</div>';
                echo '</div>';
             echo ' </div>';
			 echo ' </div>';
			echo '<hr>';
			echo '<br>';			 
            echo '<div class="row">';
              echo '<div class="col-md-6 stretch-card grid-margin" >';
                echo '<div class="card card-img-holder text-white " style="background-color:#0071BD" >';
                  echo '<div class="card-body">';
                    echo '<img src="api/uploaded_profile/'.$profile_pic_lead.'" class="card-img-absolute" alt="circle-image" />';
                    echo '<div style="margin:auto">';
					echo '<h4 class="font-weight-normal mb-3">Leader</h4>';
                    echo '<h3 class="mb-5">'.$leader_name.' <br> '.$leader_last_name.'</h3>';
					echo '</div>';
                  echo '</div>';
                echo '</div>';
             echo ' </div>';
              echo '<div class="col-md-6 stretch-card grid-margin">';
                echo '<div class="card card-img-holder text-white" style="background-color:#0071BD" >';
                  echo '<div class="card-body">';
                    echo '<img src="api/uploaded_profile/'.$profile_pic_co_lead.'" class="card-img-absolute" alt="circle-image" />';
                    echo '<h4 class="font-weight-normal mb-3">Co Leader</h4>';
                    echo '<h3 class="mb-5">'.$co_lead_name.' <br>  '.$co_lead_last_name.'</h3>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
			echo '<hr>';
			echo '<br>';
			
			
$sql2 = "SELECT * FROM team_members, user_acc where team_members.user_acc_id=user_acc.user_acc_id AND team_members.team_name_id='$team_id' ORDER BY memb_id DESC";
    
$result2 = $conn->query($sql2);
 echo '<div class="row">';
while($row3 = $result2->fetch_array()) 
   {			
           
              echo '<div class="col-md-3 stretch-card grid-margin">';
                echo '<div class="card  card-img-holder text-white" style="background-color:#2c3e50" >';
                  echo '<div class="card-body">';
				  echo '<img src="api/uploaded_profile/'.$row3["profile_pic"].'" style="height: 40%; width: 100%; border-radius: 50%; "/>';
				  echo '<br><br><hr>';
                    echo '<h4 class="font-weight-normal mb-3">Member</h4>';
                    echo '<h3 class="mb-5">'.$row3["firstname"].' '.$row3["middle_name"].' '.$row3["lastname"].'</h3>';
                  echo '</div>';
				   
                echo '</div>';
              echo '</div>';

            
   }
	echo '</div>';			
    $conn->close();
?>