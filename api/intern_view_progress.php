<?php

	include("db/dbconnection.php");
	$user_id = $_GET ['id'];
	$position = $_GET ['pos'];
	$curr_team_id = "";
	$bool_have_team = true;
	if($position != 1){
		
		$sql3 = "SELECT * FROM team_members WHERE user_acc_id = ". $user_id;
		$result3 = $conn->query($sql3);
		if(mysqli_num_rows($result3) == 0){
			//echo "<script>console.log('Debug Objects: " .mysqli_num_rows($result3). "' );</script>";
			$bool_have_team = false;

		}else{
			while($row3 = $result3->fetch_assoc()) {
				$curr_team_id = $row3["team_name_id"];
				$bool_have_team = true;
				//echo "<script>console.log('Debug Objects: " .$curr_team_id. "' );</script>";
			}
		}
		
	}elseif ($position == 1) {
		$sql3 = "SELECT * FROM team WHERE leader_id = ".$user_id;
		$result3 = $conn->query($sql3);
		while($row3 = $result3->fetch_assoc()) {
		$curr_team_id = $row3["team_id"];
		}
	}
	// $sql4 = "SELECT * FROM team WHERE team_id = ".$user_id;
	// $result4 = $conn->query($sql4);
    // $sql3 = "SELECT * FROM ";
	if($bool_have_team == true){
	$sql = "SELECT * FROM team_proj_progress WHERE team_id = ".$curr_team_id." ORDER BY team_proj_progress.team_id ASC";
		
    $result = $conn->query($sql);
    $teams = array();
	$bool = false;

    //temp variables
    $temp_team_id = "";
    $temp_user_acc_id = "";
    $temp_percentage = "";
	if ($result->num_rows > 0)
	{
		echo "<script>console.log('Debug Objects: " .$curr_team_id. "' );</script>";
		while($row = $result->fetch_array()) {
			if ($bool == false)
			{
				$temp_team_id = $row["team_id"];
				$temp_user_acc_id = $row["user_acc_id"];
				$temp_percentage = $row["proj_percentage"];
				$bool = true;
			}
			else
			{
				if ($row["team_id"] == $temp_team_id)
				{
					$temp_percentage += (int)$row["proj_percentage"];
				}
				else
				{
					$team_data = array();

					$sql2 = "SELECT * FROM team WHERE team_id=".$temp_team_id;
					$result2 = $conn->query($sql2);
					$row2 = $result2->fetch_array();

					$team_data["team_name"] = $row2["team_name"];


					$team_data["percentage"] = $temp_percentage;	  

					$sql2 = "SELECT * FROM user_acc WHERE user_acc_id=".$temp_user_acc_id;
					$result2 = $conn->query($sql2);
					$row2 = $result2->fetch_array();

					$team_data["team_leader_name"] = $row2["firstname"]." ".$row2["middle_name"]." ".$row2["lastname"];

					array_push($teams, $team_data);

					$temp_team_id = $row["team_id"];
					$temp_user_acc_id = $row["user_acc_id"];
					$temp_percentage = $row["proj_percentage"];
				}
			}

			$output = $temp_percentage;
			echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
		}

			$team_data = array();

			$sql2 = "SELECT * FROM team WHERE team_id=".$temp_team_id;
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_array();

			$team_data["team_name"] = $row2["team_name"];


			$team_data["percentage"] = $temp_percentage;	  

			$sql2 = "SELECT * FROM user_acc WHERE user_acc_id=".$temp_user_acc_id;
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_array();

			$team_data["team_leader_name"] = $row2["firstname"]." ".$row2["middle_name"]." ".$row2["lastname"];

			array_push($teams, $team_data);


		foreach ($teams as $data)
		{
			echo "<div class=\"card1\" style=\"height: 30rem;\">" ;
			echo "<center><h4 id=\"team_name\" style=\"color: blue;\"></h4>" . $data["team_name"] . "</center>";
			echo "<input type=\"hidden\" class=\"form-control\" id=\"team_id\" name=\"team_id\" required>";
			echo "<hr  style=\"border: 0;clear:both;display:block;width: 96%;background-color:#000000;\" />";
			echo "<br>";
			echo "<div class=\"percent\">

					<svg>
						<circle cx=\"105\" cy=\"105\" r=\"100\"></circle>
						<circle cx=\"105\" cy=\"105\" r=\"100\" style=\"--percent: ". $data["percentage"] ." \"></circle>
					</svg>
				
					<div class=\"number\">

						<h3 id=\"team_project_percent\">". $data["percentage"] ."<span>%</span></h3>
					</div>

				</div>";

			echo "<br>
					<br>
					<br>

					

					<center><h4 id=\"team_leader\" style=\"color: blue;\">". $data["team_leader_name"] ."</h4></center>
					<h4>TEAM LEADER</h4>
				<br>";


			echo "</div>";
		}
		}else{
			
			echo "<h4 class=\"card-title\"  id=\"no_team\" style=\"font-size: 25px;\"><center>NO DATA FOUND</center></h4>";
		}
			}
	else{
		echo "<h4 class=\"card-title\"  id=\"no_team\" style=\"font-size: 25px;\"><center>You don't have a team yet. Please coordinate with the core team.</center></h4>";
	}$conn->close();
	?>
	