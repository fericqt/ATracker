<?php
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
		
		$servername="localhost";
		$username="id18628321_a_tracker_final_v2";
		$password="UIP_Trackerv2_2022";
		$database="id18628321_a_tracker_final";
		
		//Create connection
		
		$conn=mysqli_connect($servername, $username, $password, $database);
		
		//Check connection
		
		if(!$conn){
			die("Connection failed!". mysqli_connect_error());
		}
?>