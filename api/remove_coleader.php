<?php

	include("db/dbconnection.php");


    $co_leader_id = $_POST['remove_coleader_id'];

    $position = 0;

    $co_leader = 0;
    

	$sql =  "UPDATE user_acc SET position='$position' where user_acc_id='$co_leader_id'";
    $sql1 =  "UPDATE team SET co_leader_id='$co_leader' where co_leader_id='$co_leader_id'";

		if ($conn->query($sql) && $conn->query($sql1)) {

			echo "1";

		}


		else {

			echo "0";

		}








$conn->close();


?>	