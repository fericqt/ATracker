<?php


	include("db/dbconnection.php");

        $app_id = $_POST['app_id'];
        $firstname = $_POST['firstname'];
		$middle_name = $_POST['middle_name'];
		$lastname = $_POST['lastname'];
		$street = $_POST['street'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
		$province = $_POST['province'];
        $birthdate = $_POST['birthdate'];
		$religion = $_POST['religion'];
		$sex = $_POST['sex'];
		$civil_status = $_POST['civil_status'];
		$email = $_POST['email'];
		$company = $_POST['company'];
		$department = $_POST['department'];		
		$start_date = $_POST['start_date'];
		$estimated_end_date = $_POST['estimated_end_date'];
		$required_hours = $_POST['required_hours'];
		$gdrive_link = $_POST['gdrive_link'];
		$mobile_no = $_POST['phone'];
        $start_shift = $_POST['start_shift'];
		$end_shift = $_POST['end_shift'];
		$permission = 0;
		$position = 0;
        $intern_status = 'Unassigned';
		$usertype = 'Intern';
		$password = randomPass();
		$hashed_pass = md5($password);

        if($start_shift == "8:00 AM"){
            $shift = "1";
            
        }else if($start_shift == "9:00 AM"){
            $shift = "2";
            
        }else{
            $shift = "3";
        }


		//$link = mysqli_real_escape_string( $gdrive_link); 
		
			$sql = "SELECT * FROM user_acc WHERE username='".$_POST['email']."'";
			$result = $conn->query($sql);
			
			if(mysqli_num_rows($result)!=0)
			{
				echo '2';
			}
			else
			{
				$sql1 = "INSERT INTO user_acc (shift, firstname, lastname, middle_name, username, passwd, usertype, position, permission) VALUES ('$shift','$firstname', '$lastname', '$middle_name', '$email', '$hashed_pass', '$usertype', '$position', $permission)";
				if ($conn->query($sql1) === TRUE) 
				{
					$sql2 = "INSERT INTO intern_info (mobile_no, username, app_id, street, barangay, city, province, birthdate, sex, religion, civil_status, company, department, intern_status, startdate,  required_hours, gdrive_link, estimated_end_date, start_shift, end_shift) VALUES ('$mobile_no','$email', '$app_id', '$street', '$barangay', '$city', '$province', '$birthdate', '$sex', '$religion', '$civil_status', '$company', '$department', '$intern_status', '$start_date', '$required_hours', '$gdrive_link', '$estimated_end_date', '$start_shift', '$end_shift')";
					if ($conn->query($sql2) === TRUE) 
					{
						$name = $firstname;
						$email1 = "feric08c@gmail.com";
						$message = "Dear ".$name.", \n\nGood day! We are delighted to welcome you in our company. Never feel shy about sharing your thoughts and ideas, as they are always welcomed, and we value them.";
								
						$email_from = "Melham Construction Corporation ".$email1;
						$email_subject = "Approved Intern";
						$email_body = "$message\n"."\nBelow is your username & password. Please don't share it to anyone. Thank you!\n\nusername: ".$email."\npassword: ".$password." \n\n-UIP HR OFFICER";
                        
						$to = $email;
                                                               
						$headers ="From: $email_from \r\n";
        
						$headers .="Reply-To: $email1 \r\n";
								       
						mail($to,$email_subject,$email_body,$headers);       
						
						echo "1";

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
    
function randomPass()
{
    $length = rand(10,20);
    $randomCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=-+_)(*&^%$#@!';
    $stringLength = strlen($randomCharacters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $randomCharacters[rand(0, $stringLength - 1)];
    }

    return $randomString;
}	

?>