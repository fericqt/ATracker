			
<?php
		include("db/dbconnection.php");
		$id = (int)$_GET['id']; 

    $sql = "SELECT * FROM user_acc, intern_info where user_acc.username=intern_info.username AND user_acc.user_acc_id='".$id."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
          
      while($row = $result->fetch_array()) {

        
        
        echo'<div class="card">';
        echo'<div class="card-body">';
          echo'<div class="d-flex flex-column align-items-center text-center">';
          echo'<img id="output" src="api/uploaded_profile/'.$row["profile_pic"].'" alt="Admin" class="rounded-circle" width="150">';
          echo'<div class="mt-3">';
          echo'<h4>'.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'</h4>';
            echo'<p class="text-secondary mb-1">'.$row["app_id"].'</p>';
            echo'<p class="text-muted font-size-sm">'.$row["department"].'</p>';
                echo'</div>';
              echo'</div>';
            echo'</div>';
          echo'</div>';  
					echo '<hr>';
                  echo'<div class="card mt-3">';
                  echo'<ul class="list-group list-group-flush">';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">REQUIRED HOURS</h6>';
                        echo'<span class="text-secondary">'.$row["required_hours"].' hrs</span>';
                        echo'</li>';				  
                    echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">RENDERED HOURS</h6>';
                        echo'<span class="text-secondary">0 hrs</span>';
                        echo'</li>';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">REMAINING HOURS</h6>';
                        echo'<span class="text-secondary">0 hrs</span>';
                        echo'</li>';
						echo'</ul></div><hr>';
						echo'<div class="card mt-3">';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">DEDUCTED HOURS</h6>';
                        echo'<span class="text-secondary">0 hrs</span>';
                        echo'</li>';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">PENALTY HOURS</h6>';
                        echo'<span class="text-secondary">0 hrs</span>';
                        echo'</li>';						
						echo'</ul></div><hr>';
				echo'<div class="card mt-3">';
                  echo'<ul class="list-group list-group-flush">';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                         $star_date = $row['startdate'];   
                         $star_date1 = date('F d, Y ', strtotime($star_date));

                      echo'<h6 class="mb-0">START DATE</h6>';
                        echo'<span class="text-secondary">'.$star_date1.'</span>';
                        echo'</li>';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';

                         $end_date = $row['estimated_end_date'];   
                         $end_date1 = date('F d, Y ', strtotime($end_date));
                      echo'<h6 class="mb-0">END DATE</h6>';
                        echo'<span class="text-secondary">'.$end_date1.'</span>';
                        echo'</li>';
					echo'</ul></div><hr>';
				echo'<div class="card mt-3">';
                  echo'<ul class="list-group list-group-flush">';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">START SHIFT</h6>';
                        echo'<span class="text-secondary">'.$row["start_shift"].'</span>';
                        echo'</li>';
                      echo'<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                      echo'<h6 class="mb-0">END SHIFT</h6>';
                        echo'<span class="text-secondary">'.$row["end_shift"].'</span>';
                        echo'</li>';
                      echo'</ul>';
                    echo'</div>';
                  echo'</div>';

		  
	  }
		
      
    } else {
      echo "0 results";
    }
    $conn->close();
?>

