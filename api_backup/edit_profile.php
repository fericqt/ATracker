<?php


	include("db/dbconnection.php");

		$user_acc_id = $_POST['user_acc_id'];
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
		$gdrive_link = $_POST['gdrive_link'];
		$mobile_number = $_POST['mobile_number'];
		$province = $_POST['province'];

		$profile_pic = $_FILES['profile_pic']['name'];

			$randomno = rand(0,100000);
			$renames = 'upload'.$randomno;
			
			$newName= $renames.$profile_pic;
			$target_dir = "uploaded_profile/";
			$target_file = $target_dir . $newName;
			
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			// Valid file extensions
			$extensions_arr = array("jpg","jpeg","png","gif");

			if(!empty($_FILES["profile_pic"]["name"]))
			{

				if( in_array($imageFileType,$extensions_arr) )
				{

					compressImage($_FILES["profile_pic"]["tmp_name"], $target_file, 30);

                    $query = "SELECT * FROM user_acc WHERE user_acc_id='".$user_acc_id."'";
						$result = $conn->query($query);
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_array()) {
							$image = $row['profile_pic'];
							$file= 'uploaded_profile/'.$image;
							unlink($file);
						}
					}

						$sql1 = "UPDATE user_acc t1 
									JOIN intern_info t2 ON (t1.username = t2.username) 
									SET t1.firstname = '$firstname', 
										t1.lastname = '$lastname',
										t1.middle_name = '$middle_name', 
										t1.profile_pic = '$newName',
										t2.street = '$street', 
										t2.barangay = '$barangay', 
										t2.city = '$city', 
										t2.birthdate = '$birthdate', 
										t2.sex = '$sex', 
										t2.religion = '$religion', 
										t2.civil_status = '$civil_status', 
										t2.company = '$company', 
										t2.department = '$department', 
										t2.gdrive_link = '$gdrive_link',
										t2.religion = '$religion', 
										t2.province = '$province', 
										t2.mobile_number = '$mobile_number'

									WHERE t1.username = '$email' AND t2.username='$email' AND t1.user_acc_id='$user_acc_id'";
									
						if ($conn->query($sql1) === TRUE) 
						{
							echo "1" ;			
					
						} else 
						{
							echo "0";
						}
				}
				else
				{
					echo "3";
				}
			}else
			{
				$sql2 = "UPDATE user_acc t1 
									JOIN intern_info t2 ON (t1.username = t2.username) 
									SET t1.firstname = '$firstname', 
										t1.lastname = '$lastname',
										t1.middle_name = '$middle_name', 
										t2.street = '$street', 
										t2.barangay = '$barangay', 
										t2.city = '$city', 
										t2.birthdate = '$birthdate', 
										t2.sex = '$sex', 
										t2.religion = '$religion', 
										t2.civil_status = '$civil_status', 
										t2.company = '$company', 
										t2.department = '$department', 
										t2.gdrive_link = '$gdrive_link',
										t2.religion = '$religion', 
										t2.province = '$province', 
										t2.mobile_number = '$mobile_number' 
									WHERE t1.username = '$email' AND t2.username='$email' AND t1.user_acc_id='$user_acc_id'";
									
						if ($conn->query($sql2) === TRUE) 
						{
							echo "1" ;			
					
						} else 
						{
							echo "0";
						}
			}

        $conn->close();
    
	
		function compressImage($source, $destination, $quality) {

			$info = getimagesize($source);
	
			if ($info['mime'] == 'image/jpeg') {
				$image = imagecreatefromjpeg($source);
			} elseif ($info['mime'] == 'image/gif') {
				$image = imagecreatefromgif($source);
			} elseif ($info['mime'] == 'image/png') {
				$image = imagecreatefrompng($source);
			}
	
			imagejpeg($image, $destination, $quality);
	
		}	
?>