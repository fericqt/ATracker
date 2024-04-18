<?php
        header('Access-Control-Allow-Origin: *');
        
		$servername="localhost";

		$username="u445178645_admintime";

		$password="M46[uMf:KT&s";

		$database="u445178645_attendance";
		//Create connection

		

		$conn=mysqli_connect($servername, $username, $password, $database);

		

		//Check connection

		

		if(!$conn){

			die("Connection failed!". mysqli_connect_error());

		}

?>