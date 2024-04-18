<?php
require_once '../includes/DBOperations.php';
require_once '../../api/vendor/autoload.php';
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if($_POST['email'] != ""){
		$db = new DBOperations();
		
		$get_smtp = $db->getSMTPEmail();
		$smtp_email = $get_smtp['smtp_gmail'];
		$smtp_pass = $get_smtp['smtp_random'];

		$send_code = $db->sendVerificationCode($_POST['email']);
		if($send_code == 1){
			$response['error'] = true;
			$response['message'] = "Password reset limit. You can only request new password once every day. Please wait tomorrow.";

		}else if($send_code == 2){
			$response['error'] = true;
			$response['message'] = "DB: Something went wrong.";
			
		}else if($send_code == 3){
			$response['error'] = true;
			$response['message'] = "User does not exist.";

		}else{

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
		    $mail->addAddress($_POST['email']);
			$mail->addReplyTo($smtp_email,'Melham Construction Corporation');
		    $mail->AddEmbeddedImage('../../api/imageMail/resetpassword.png', 'banner');
			//message
			
			
			$mail->isHTML(true);	
			$message = "<div style='border-left-width: 7px; border-left-style: solid; border-left-color: #0071BD; background-color: #d4dbd5; border-radius: 5px; width:650px;'><h4><b><p style='padding:15px 10px 15px 10px;'>Hi ".$_POST['email'].",<br><br>There was a request to change your password!<br><br>If you did not make this request then please ignore this email.<br><br>Otherwise, here is the code for resetting your password:<br/><br/><h2> ".$send_code."</h2> <br><br>Thanks,<br><br>The Project IT-29 Team</p></b></h4></div>";
			
		    // Content
		    $mail->Subject = "PASSWORD RESET";
		    $mail->Body    = '<img style="height:300px; width:650px" alt="Loading image..." src="cid:banner"><br>'.$message.'<br><br><br><footer><div style="text-align: center; font-size: 12px;color:black; height:30px; width: 100%;"><p>Copyright &copy; '.date("Y").' Melham Construction Corporation | Project IT-29 Team</p></div></footer>';
		    $mail->send();

			$response['code'] = $send_code;
			$response['message'] = "Code sent to your email.";
			$response['error'] = false;
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Required fields are missing.";
	}
	
}else{
	$response['error'] = true;
	$response['message'] = "Invalid request.";
}

echo json_encode($response);
?>