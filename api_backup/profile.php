			
<?php
		include("db/dbconnection.php");
		$id = (int)$_GET['id']; 

    $sql = "SELECT * FROM user_acc, intern_info where user_acc.username=intern_info.username AND user_acc.user_acc_id='".$id."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
          
      while($row = $result->fetch_array()) {
		
        echo'<div class="row gutters-sm">';
        echo'<div class="col-md-4 mb-3">';
                echo'<div class="card">';
                  echo'<div class="card-body">';
                    echo'<div class="d-flex flex-column align-items-center text-center">';
                      echo'<img src="api/uploaded_profile/'.$row["profile_pic"].'" alt="Admin" class="rounded-circle" width="150">';
                        echo'<div class="mt-3">';
                        echo'<h4>'.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'</h4>';
                          echo'<p class="text-secondary mb-1">'.$row["app_id"].'</p>';
                          echo'<p class="text-muted font-size-sm">'.$row["department"].'</p>';
                          echo'</div>';
                        echo'</div>';
                      echo' </div>';
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
                
                
                echo'<div class="col-md-8 ">';
                echo'<div class="card mb-3">';
                  echo'<div class="card-body">';
                    echo'<div class="row gutters-sm">';
                      echo'<div class="col-sm-6 mb-3">';
                            
                        echo'<div class="row">';
                       echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Name:</h6>';
                                  echo'</div>';
                                   echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'';
                                    echo'</div></center>';
                                  echo'</div>';
                                  echo'<hr>';
                                echo'<div class="row">';
                                echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Email:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["username"].'';
                                            echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';
                                echo'<div class="row">';
                                echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Mobile No.:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo' '.$row["mobile_number"].'';
                                          echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';
                               echo'<div class="row">';
                                echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Street:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["street"].'';
                                        echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';

                               echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Barangay:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["barangay"].'';
                                        echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';

                               echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">City:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["city"].'';
                                        echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';

                               echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Province:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["province"].'';
                                        echo'</div>';
                                    echo'</div></center>';
                                  echo'<hr>';
                               
                              
                               echo'</div>';
          
                                echo'<div class="col-sm-6 mb-4">';
                            
                         
                                $Birthdate = $row['birthdate'];   
                                $Birthdate1 = date('F d, Y ', strtotime($Birthdate));

                         echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Birthdate:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$Birthdate1.'';
                                        echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';

                               echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Gender :</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["sex"].'';
                                        echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';

                               echo'<div class="row">';
                               echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Civil Status:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["civil_status"].'';
                                        echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';

                               echo'<div class="row">';
                          echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Religion:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["religion"].'';
                                          echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';
                                echo'<div class="row">';
                                echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Company:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["company"].'';
                                            echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';
                                echo'<div class="row">';
                                echo'<center><div class="col-sm-7">';
                                echo'<h6 class="mb-0">Dept:</h6>';
                                  echo'</div>';
                                    echo'<div class="col-sm-12 text-secondary">';
                                  echo''.$row["department"].'';
                                          echo'</div>';
                                    echo'</div>';
                                  echo'<hr>';
                                  echo'<div class="row">';
                                  echo'<center><div class="col-sm-7">';
                                  echo'<h6 class="mb-0">G-Drive:</h6>';
                                  echo'</div>';
                                      echo'<div class="col-sm-12 text-secondary">';
                                      echo'<a href="'.$row["gdrive_link"].' "style="text-decoration: none" target="_blank">G-DRIVE LINK</a>';
                                              echo'</div>';
                                      echo'</div>';
                                    echo'<hr>';
                                    echo'</div>';

                                
                                echo'</div>';
                        
                          echo'<div class="row">';
                        echo'<div class="col-sm-12">';
                        echo'<a class="btn btn-dark " href="edit_profile.html">EDIT</a>';
                          echo'</div>';
                            echo'</div>';
                          echo'</div>';
                        echo'</div>';
                      echo'</div>';
                     echo'</div>';
		  
	  }
		
      
    } else {
      echo "0 results";
    }
    $conn->close();
?>

