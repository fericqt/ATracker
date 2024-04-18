<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['app_id']) && isset($_POST['firstname']) && isset($_POST['middle_name']) && isset($_POST['lastname']) && isset($_POST['street']) && isset($_POST['barangay']) && isset($_POST['city']) && isset($_POST['birthdate']) && isset($_POST['religion']) && isset($_POST['gender']) && isset($_POST['civil_status']) && isset($_POST['email']) && isset($_POST['user_name']) && isset($_POST['company']) && isset($_POST['department']) && isset($_POST['intern_status']) && isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['required_hours']) && isset($_POST['gdrive_link'])){

        $app_id = $_POST['app_id'];
        $firstname = $_POST['firstname'];
		$middle_name = $_POST['middle_name'];
		$lastname = $_POST['lastname'];
		$street = $_POST['street'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
        $birthdate = $_POST['birthdate'];
		$religion = $_POST['religion'];
		$gender = $_POST['gender'];
		$civil_status = $_POST['civil_status'];
		$email = $_POST['email'];
		$company = $_POST['company'];
		$department = $_POST['department'];
		$intern_status = $_POST['intern_status'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$required_hours = $_POST['required_hours'];
		$gdrive_link = $_POST['gdrive_link'];
		$user_name = $_POST['user_name'];
		$permission = 0;
		$position = 0;
        $pwd = 123456;
		$usertype = 'Intern';

		//$link = mysqli_real_escape_string( $gdrive_link); 
		
		if(isset($_POST['user_name']))
		{
			$sql = "SELECT * FROM user_acc WHERE username='".$_POST['user_name']."'";
			$result = $conn->query($sql);
			
			if(mysqli_num_rows($result)!=0)
			{
				echo '2';
			}
			else
			{
				$sql1 = "INSERT INTO user_acc (firstname, lastname, middle_name, username, passwd, usertype, position, permission) VALUES ('$firstname', '$lastname', '$middle_name', '$user_name', '$pwd', '$usertype', '$position', $permission)";
				if ($conn->query($sql1) === TRUE) 
				{
					$sql2 = "INSERT INTO intern_info (username, app_id, street, barangay, city, birthdate, religion, gender, civil_status, email, company, department, intern_status, startdate, end_date, required_hours, gdrive_link) VALUES ('$user_name', '$app_id', '$street', '$barangay', '$city', '$birthdate', '$religion', $gender, '$civil_status', '$email', '$company', '$department', '$intern_status', '$start_date', $end_date, '$required_hours', '$gdrive_link')";
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

        }
        $conn->close();
    }
	

?>