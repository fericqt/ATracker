			
<?php
		include("db/dbconnection.php");
		$id = (int)$_GET['id']; 

    $sql = "SELECT * FROM user_acc, intern_info where user_acc.username=intern_info.username AND intern_info.intern_info_id='".$id."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
          
      while($row = $result->fetch_array()) {

     $email = $row["username"];
	$rqrd_hrs=0;
	$add_hrs=0;
	
    $sql4 = "SELECT * FROM intern_info WHERE username = '$email'";
    
	$result4 = $conn->query($sql4);
    
    $response = array();
    
    if ($result4->num_rows > 0) {

	  if($row4 = $result4->fetch_assoc()) {
		$add_hrs = $row4["added_hours"];
		if($add_hrs == 0)
		{
			$rqrd_hrs = $row4["required_hours"];
			$add_hrs="0";
		}
		else{
			$rqrd_hrs = $row4["required_hours"] - $add_hrs; 
			$add_hrs = $row4["added_hours"];
		}
		
	  }
	} 

        $user_id = $row["user_acc_id"];
        
		$sql5 = "SELECT SUM(hrs_today) AS hrs_added FROM attendance WHERE user_acc_id = '$user_id'";
    
		$result5 = mysqli_query($conn, $sql5);
        $row5 = $result5->fetch_assoc();
        if($row5["hrs_added"]=="")
        {
            $hrs_added = 0;
        }else{
        $hrs_added = $row5["hrs_added"];
        }
        
        $hrs_left = $rqrd_hrs - $hrs_added;
        
        echo '<div class="row gutters-sm justify-content-center">';
        echo '<div class="col-md-3 mb-3">';
        echo '<div class="card">';
          echo '<div class="card-body">';
            echo '<div class="d-flex flex-column align-items-center text-center">';
              echo '<img src="assets/images/faces/mandi.jpg" alt="Admin" class="rounded-circle" width="150">';
                echo '<div class="mt-3">';
                echo '<h4>'.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'</h4>';
                  echo '<p class="text-secondary mb-1">'.$row["app_id"].'</p>';
                  echo '<p class="text-muted font-size-sm">'.$row["department"].'</p>';
                  
                  echo '</div>';
                echo '<div style="line-height:30%;">';
                echo '<br>';
                  echo '</div>';
              echo '</div>';
              echo '</div>';
            echo '</div>';
          echo '<div style="line-height:100%;">';
          echo '<br>';
            echo '</div>';
        echo '<div class="card mt-3">';
          echo '<ul class="list-group list-group-flush">';
            echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">REQUIRED HOURS</h6>';
                echo '<span class="text-secondary">'.$row["required_hours"].' hrs</span>';
                echo '</li>';
              echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">RENDERED HOURS</h6>';
                echo '<span class="text-secondary">'.$hrs_added.' hrs</span>';
                echo '</li>';
              echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">REMAINING HOURS</h6>';
                echo '<span class="text-secondary">'.$hrs_left.' hrs</span>';
                echo '</li>';
              echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">DEDUCTED HOURS</h6>';
                echo '<span class="text-secondary">'.$add_hrs.' hrs</span>';
                echo '</li>';  
              echo '</ul>';
            echo '</div>';
          echo '</div>';
        echo '<div class="col-md-8">';
        echo '<div class="card mb-3">';
          echo '<div class="card-body">';
            echo '<div class="row gutters-sm">';
              echo '<div class="col-sm-6 mb-3">';
                  
                echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Name:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Email:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["username"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Mobile No.:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["mobile_no"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Address:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["street"].', '.$row["barangay"].', '.$row["city"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                    
                      echo '</div>';

                echo '<div class="col-sm-6 mb-3">';
                  
                echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Birthdate:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["birthdate"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Religion:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["religion"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Gender:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["sex"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                      echo '<div class="row">';
                      echo '<div class="col-sm-3">';
                        echo '<h6 class="mb-0">Civil Status:</h6>';
                          echo '</div>';
                        echo '<div class="col-sm-9 text-secondary">';
                        echo ''.$row["civil_status"].'';
                          echo '</div>';
                        echo '</div>';
                      echo '<hr>';
                  
                      echo '</div>';
                echo '</div>';
              
              echo '<div class="row">';
              echo '<div class="col-sm-12">';
                echo '<a class="btn btn-dark " href="view_intern.html">Go Back</a>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            
            echo '</div>';
          

          echo '<div class="row gutters-sm">';
          echo '<div class="col-sm-6 mb-3">';
            echo '<div class="card mt-3">';
              echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">COMPANY</h6>';
                    echo '<span class="text-secondary">'.$row["company"].'</span>';
                    echo '</li>';
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">DEPARTMENT</h6>';
                    echo '<span class="text-secondary">'.$row["department"].'</span>';
                    echo '</li>';
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">INTERN STATUS</h6>';
                    echo '<span class="text-secondary">'.$row["intern_status"].'</span>';
                    echo '</li>';                    
                  echo '</ul>';
                echo '</div>';
              echo '</div>';


            echo '<div class="col-sm-6 mb-3">';
            echo '<div class="card mt-3">';
              echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">START TIME SHIFT</h6>';
                    echo '<span class="text-secondary">'.$row["start_shift"].'</span>';
                    echo '</li>';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">END TIME SHIFT</h6>';
                    echo '<span class="text-secondary">'.$row["end_shift"].'</span>';
                    echo '</li>';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">START DATE</h6>';
                    echo '<span class="text-secondary">'.$row["startdate"].'</span>';
                    echo '</li>';
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">ESTIMATED END DATE</h6>';
                    echo '<span class="text-secondary">'.$row["estimated_end_date"].'</span>';
                    echo '</li>';
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
                  echo '<h6 class="mb-0">GOOGLE DRIVE LINK</h6>';
                    echo '<span class="text-secondary"><a href="'.$row["gdrive_link"].' "style="text-decoration: none" target="_blank">G-DRIVE LINK</a></span>';
                    echo '</li>';
                  
                  echo '</ul>';
                echo '</div>';
              echo '</div>';
            echo '</div>';

          echo '</div>';
        echo '</div>';
		  
	  }
		
      
    } else {
      echo "0 results";
    }
    $conn->close();
?>

