<?php

	include("db/dbconnection.php");


	$team_id = $_POST['team_id'];
    $user_acc_id = $_POST['user_acc_id'];
    $team_proj_percent_id = $_POST['team_proj_percent_id'];
	$date = date_create()->format('Y-m-d');

    

	$sql =  "INSERT INTO team_proj_progress (team_id, user_acc_id, proj_percentage, date_submitted)
			 VALUES ('$team_id', '$user_acc_id', '$team_proj_percent_id', '$date')";

		if ($conn->query($sql) === TRUE) {

			echo "1";

		}


		else {

			echo "0";

		}








$conn->close();


?>	