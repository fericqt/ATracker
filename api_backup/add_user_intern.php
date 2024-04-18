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
		$permission = 0;
		$position = 0;
		$usertype = 'Intern';

		//$link = mysqli_real_escape_string( $gdrive_link); 
		
			$sql = "SELECT * FROM user_acc WHERE username='".$_POST['email']."'";
			$result = $conn->query($sql);
			
			if(mysqli_num_rows($result)!=0)
			{
				echo '2';
			}
			else
			{
				$sql1 = "INSERT INTO user_acc (firstname, lastname, middle_name, username, passwd, usertype, position, permission) VALUES ('$firstname', '$lastname', '$middle_name', '$email', '$pwd', '$usertype', '$position', $permission)";
				if ($conn->query($sql1) === TRUE) 
				{
					$sql2 = "INSERT INTO intern_info (username, app_id, street, barangay, city, birthdate, sex, religion, civil_status, company, department, intern_status, startdate,  required_hours, gdrive_link, estimated_end_date) VALUES ('$email', '$app_id', '$street', '$barangay', '$city', '$birthdate', '$sex', '$religion', '$civil_status', '$company', '$department', '$intern_status', '$start_date', '$required_hours', '$gdrive_link', '$estimated_end_date')";
					if ($conn->query($sql2) === TRUE) 
					{
						echo "1" ;			
				
					} else 
					{
						echo "0";
					}			
			
				} else 
				{
					echo "0";
				}	 
			}

        
        $conn->close();
    
	

?>