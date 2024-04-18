<?php

	include("db/dbconnection.php");


	$curr_user_id = $_GET['id'];

    $sql = "SELECT SUM(proj_percentage) AS totalPercentage FROM team_proj_progress WHERE user_acc_id=" . $curr_user_id;
    $result = $conn->query($sql);

    if ($result->num_rows>0){
    	while ($row = $result->fetch_assoc()){
    		echo $row["totalPercentage"] . "%";
    	}
    }else{
    	echo "0";
    }


$conn->close();


?>	