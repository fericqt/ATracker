<?php
require_once '../includes/DBOperations.php';
require_once '../../api/vendor/autoload.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new DBOperations();
	date_default_timezone_set('Asia/Manila');
	$get_smtp = $db->getSMTPEmail();
	$smtp_email = $get_smtp['smtp_gmail'];
	$smtp_pass = $get_smtp['smtp_random'];

	$output_image = $_POST['image'];
	$randomno = rand(0,100000);
	$name = "upload".$randomno.time();
	$upload_path = "../../api/uploaded_profile/".$name.".jpeg";

	$shift = $db->getShift($_POST['start_shift']);

	$date = date('F d, Y');
	$time = date('g:i A');
	$date_registered = $date." at ".$time;

	switch($_POST['schedule']){

		case "Monday, Wednesday, Friday":
			$schedule = "Monday/Wednesday/Friday";
			break;
		case "Tuesday, Thursday, Saturday":
			$schedule = "Tuesday/Thursday/Friday";
			break;
		case "Monday to Friday":
			$schedule = "Monday/Tuesday/Wednesday/Thursday/Friday";
			break;
		case "Monday to Saturday":
			$schedule = "Monday/Tuesday/Wednesday/Thursday/Friday/Saturday";
			break;
	}


	if(!$db->isUserExist($_POST['email'])){
		if(file_put_contents($upload_path, base64_decode($output_image))){
			$image = $name.".jpeg";

			$user_data = array("first_name" => $_POST['first_name'],
								"last_name" => $_POST['last_name'],
								"middle_name" => $_POST['middle_name'],
								"email" => $_POST['email'],
								"password" => md5("123"),
								"usertype" => "Intern",
								"shift" => $shift,
								"position" => "0",
								"permission" => "0",
								"last_login" => time(),
								"date_registered" => $date_registered,
								"profile_pic" => $image,
								"app_id" => $_POST['app_id'],
								"street" => $_POST['street'],
								"barangay" => $_POST['barangay'],
								"city" => $_POST['city'], 
								"province" => $_POST['province'],
								"birthdate" => $_POST['birthdate'],
								"mobile_no" => $_POST['mobile_no'],
								"sex" => $_POST['sex'],
								"religion" => $_POST['religion'],
								"civil_status" => $_POST['civil_status'],
								"school" => $_POST['university'],
								"company" => $_POST['company'],
								"department" => $_POST['department'],
								"intern_status" => "Unassigned",
								"start_date" => $_POST['start_date'],
								"required_hrs"=>$_POST['required_hrs'],
								"gdrive_link" => $_POST['gdrive_link'],
								"end_date" => $_POST['end_date'],
								"start_shift"=> $_POST['start_shift'],
								"end_shift"=> $_POST['end_shift'],
								"schedule" => $schedule);



			$insert_user = $db->registerUserData($user_data);
			if($insert_user){
				$response['error'] = false;
				$response['message'] = "Data has been successfully inserted.";

						$mail = new \PHPMailer\PHPMailer\PHPMailer(true);



                        $mail->SMTPDebug = 0;

                        $mail->isSMTP();

                        $mail->Host = 'smtp.gmail.com';

                        $mail->Port = 587;

                        $mail->SMTPAuth = true;

                        $mail->SMTPSecure = 'tls';                       

                        $mail->Username = $smtp_email;

                        $mail->Password = $smtp_pass;



                        // Recipients

                        $mail->setFrom($smtp_email, 'Melham Construction Corporation');

                        $mail->addAddress($email,$name);

	                    $mail->addReplyTo($smtp_email,'Melham Construction Corporation');

                        $mail->AddEmbeddedImage('../../api/imageMail/welcome.png', 'banner');

	                    //message
	

	                    $mail->isHTML(true);	

	                    $message = "<div style='border-left-width: 7px; border-left-style: solid; border-left-color: #0071BD; background-color: #d4dbd5; border-radius: 5px; width:650px;'><h4><b><p style='padding:15px 10px 15px 10px;'>Hello ".$_POST['first_name'].",<br><br>Thank you for choosing Melham Construction Corporation Company. Please wait for your approval as we are checking your documents and check the spam folder from time to time thank you. Have a great day ahead!<br><br>Project IT-29 Team</p></b></h4></div>";

	

                        // Content

                        $mail->Subject = "WAITING FOR APPROVAL";

                        $mail->Body    = '<img style="height:300px; width:650px" alt="Loading image..." src="cid:banner">'.$message.'<br><br><br><footer><div style="text-align: center; font-size: 12px;color:black; height:30px; width: 100%;"><p>Copyright &copy; '.date("Y").' Melham Construction Corporation | Project IT-30 Team</p></div></footer>';

                        $mail->send();


			}else{
				$response['error'] = true;
				$response['message'] = "DB: Something went wrong.";
			}
		}else{
			$response['error'] = false;
			$response['message'] = "Image upload failed.";
		}

	}else{
		$response['error'] = false;
		$response['message'] = "Email is existing. Please login with your account.";
	}
	
	

}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);

?>