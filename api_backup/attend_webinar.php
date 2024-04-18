			
<?php
		include("db/dbconnection.php");

    $sql = "SELECT * FROM webinar, user_acc where webinar.user_acc_id=user_acc.user_acc_id ORDER BY webinar.date_posted DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
          
      while($row = $result->fetch_array()) {

        $date_posted = $row['date_posted'];   
        $date_posted = date('F d, Y ', strtotime($date_posted));
        $date_meeting = $row['meeting_date'];   
        $date_meeting = date('F d, Y ', strtotime($date_meeting));
        
                  echo'<h3 class="card-title">'.$row["firstname"]." ".$row["middle_name"]." ".$row["lastname"].'<br>';
                  if($row["usertype"] == 'Admin')
                  {
                  echo'<p style="font-size: 13px;">ADMIN | '.$date_posted.'</p></h3>';

                  }
                  else if($row["usertype"] == 'Staff')
                  {
                  echo'<p style="font-size: 13px;">STAFF | '.$date_posted.'</p></h3>';

                  }
                  echo'<p>Title: <strong>'.$row["title_name"].'</strong></p>';
                  echo'<p>Description: '.nl2br($row["webinar_desc"]).'</p>';
                  echo'<p> When: <strong>'.$date_meeting.', '.$row["meeting_time"].'</strong></p>';
                  echo'<p>Meeting Link: <a href="'.$row["meeting_link"].'" style="text-decoration: none" target="_blank">Click Here</a></p>';
                       
                  if($row["web_status"]== 1)
                  {
                    echo'<p>Registration Fee: <strong>'.$row["registration_fee"].'</strong> | <label class="badge badge-danger">CLOSED</label></p>';
                  }
                  else
                  {
                    echo'<p>Registration Fee: <strong>'.$row["registration_fee"].'</strong> | <a onclick="webinar_id('.$row["webinar_id"].')"><button data-bs-toggle="modal" data-bs-target="#modal-webinar_paid"  class="badge badge-success">Pay Here</button></a></p>';
                  }
                  
                
                  echo '<br>';
                  echo '<hr>';
                  echo '<br>';
	  } 
		
      
    } else {
      echo "0 results";
    }
    $conn->close();
?>

