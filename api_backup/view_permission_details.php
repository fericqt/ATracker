			
<?php
		include("db/dbconnection.php");
		$id = (int)$_GET['id']; 

    $sql = "SELECT * FROM user_acc, intern_info where user_acc.username=intern_info.username AND intern_info.intern_info_id='".$id."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
          
      while($row = $result->fetch_array()) {

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
                echo '<span class="text-secondary">'.$row["required_hours"].'</span>';
                echo '</li>';
              echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">RENDERED HOURS</h6>';
                echo '<span class="text-secondary">Not yet</span>';
                echo '</li>';
              echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">';
              echo '<h6 class="mb-0">REMAINING HOURS</h6>';
                echo '<span class="text-secondary">Not yet</span>';
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
                        echo ''.$row["username"].'';
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
                echo '<a class="btn btn-dark " href="permission.html">Go Back</a>';
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

