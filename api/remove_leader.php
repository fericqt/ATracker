<?php

	include("db/dbconnection.php");


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








$conn->close();


?>	