<?php

	include("db/dbconnection.php");

    $sql = "SELECT * FROM team_proj_progress ORDER BY `team_proj_progress`.`team_id` ASC";

    $result = $conn->query($sql);

    $teams = array();

    $bool = false;

    //temp variables
    $temp_team_id = "";
    $temp_user_acc_id = "";
    $temp_percentage = "";

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

		  		$team_data["team_ID"] = $temp_team_id;

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
		//echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
  	}

  		$team_data = array();

  		$team_data["team_ID"] = $temp_team_id;

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

		//echo json_encode($teams);
		$card = 0;
	foreach ($teams as $data)
	{


		echo "<div class=\"card\" style=\"height: 30rem;\">";
		echo "<center><h4 id=\"team_name\" style=\"color: blue;\"></h4>" . $data["team_name"] . "</center>";
		echo "<input type=\"hidden\" class=\"form-control\" id=\"team_id\" name=\"team_id\" required>";
		echo "<hr  style=\"border: 0;clear:both;display:block;width: 96%;background-color:#000000;\" />";

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

			   

			    <center><h4 id=\"team_leader\" style=\"color: blue;\">". $data["team_leader_name"] ."</h4></center>
			    <h4>TEAM LEADER</h4>

		      <br>";

		echo "<input type=\"hidden\" class=\"form-control\" name=\"View_Date_Progress_Logs\" id=\"View_Date_Progress_Logs\" required> 

				<input style=\"display: none\" type=\"text\" id=\"field" . $card ."\" value=\"" . $data["team_ID"] . "\">

	            <button type=\"submit\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-datalogs\" class=\"badge badge-info\" onclick=\"Date_Progress_Logs('" . $data["team_ID"] . "')\">
	            View Date Progress Logs
	            </button>";

		echo "</div>";
		$card += 1;

  	}



/*
    $leader_id = $_POST['remove_leader_id'];

    $position = 0;

    $leader = 0;
    

	$sql =  "UPDATE user_acc SET position='$position' where user_acc_id='$leader_id'";
    $sql1 =  "UPDATE team SET leader_id='$leader' where leader_id='$leader_id'";

		if ($conn->query($sql) && $conn->query($sql1)) {

			echo "1";

		}


		else {

			echo "0";

		}
*/


 /*   function array_data($temp_team_id, $temp_percentage, $temp_user_acc_id, $teams)
    {
  		$team_data = array();

  		    $sql2 = "SELECT * FROM team WHERE team_id=".$temp_team_id;
    		$result2 = $conn->query($sql2);
    		$row2 = $result2->fetch_array();

  		$team_data["team_name"] = $row2["team_name"];


      	$team_data["percentage"] = $temp_percentage;	  

  		    $sql2 = "SELECT * FROM user_acc WHERE user_acc_id=".$temp_user_acc_id;
    		$result2 = $conn->query($sql);
    		$row2 = $result->fetch_array();

      	$team_data["team_leader_name"] = $row2["firstname"]." ".$row2["middle_name"]." ".$row2["lastname"];

      	return $team_data;
    }
*/

$conn->close();


?>	