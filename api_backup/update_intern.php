<?php


	include("db/dbconnection.php");

        $app_id = $_POST['app_id'];
        $firstname = $_POST['firstname'];
		$middle_name = $_POST['middle_name'];
		$lastname = $_POST['lastname'];
		$street = $_POST['street'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
        $birthdate = $_POST['birthdate'];
		$religion = $_POST['religion'];
		$sex = $_POST['sex'];
		$civil_status = $_POST['civil_status'];
		$email = $_POST['email'];
		$company = $_POST['company'];
		$department = $_POST['department'];
		$intern_status = $_POST['intern_status'];
		$start_date = $_POST['start_date'];
		$estimated_end_date = $_POST['estimated_end_date'];
		$required_hours = $_POST['required_hours'];
		$gdrive_link = $_POST['gdrive_link'];
		$pwd = $_POST['pwd'];


				$sql1 = "UPDATE user_acc t1 
							JOIN intern_info t2 ON (t1.username = t2.username) 
							SET t1.firstname = '$firstname', 
								t1.lastname = '$lastname',
								t1.middle_name = '$middle_name', 
								t1.passwd = '$pwd',
								t2.app_id = '$app_id', 
								t2.street = '$street', 
								t2.barangay = '$barangay', 
								t2.city = '$city', 
								t2.birthdate = '$birthdate', 
								t2.sex = '$sex', 
								t2.religion = '$religion', 
								t2.civil_status = '$civil_status', 
								t2.company = '$company', 
								t2.department = '$department', 
								t2.intern_status = '$intern_status', 
								t2.startdate = '$start_date', 
								t2.required_hours = '$required_hours',
								t2.gdrive_link = '$gdrive_link',
								t2.estimated_end_date = '$estimated_end_date' 
							WHERE t1.username = '$email'";
							
				if ($conn->query($sql1) === TRUE) 
				{
					echo "1" ;			
			
				} else 
				{
					echo "0";
				}

        $conn->close();
    
	

?>