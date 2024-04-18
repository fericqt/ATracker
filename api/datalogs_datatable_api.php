<?php


	


	include("db/dbconnection.php");
	$team_id = $_GET['id']; 

    


    $sql = "SELECT * FROM team_proj_progress, team WHERE team.team_id=team_proj_progress.team_id AND team_proj_progress.team_id=".$team_id;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      $response['data'] = array();


      // output data of each row


      


      while($row = $result->fetch_array()) {


            $view_datalog = array();


            $view_datalog["Team ID"] = $row["team_id"];


            $view_datalog["Team Name"] = $row["team_name"];	  


            $view_datalog["Project Percentage"] = $row["proj_percentage"];


            $view_datalog["Date Submitted"] = $row["date_submitted"];

      
		 	array_push($response['data'], $view_datalog); 

	  }


      echo json_encode($response);


    } else {


      echo json_encode(array('data'=>''));


    }


    $conn->close();


?>