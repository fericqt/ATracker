<?php
	
	include("db/dbconnection.php");
	
    $sql = "SELECT team_name FROM team where co_leader_id=0";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		$view_team_name = array();
		$view_team_name = $row["team_name"];
        array_push($response, $view_team_name);
	  }
      
      echo json_encode($response);
      
    } else {
      echo "0 results";
    }
    $conn->close();
?>