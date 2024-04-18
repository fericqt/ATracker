<?php 

class DBOperations{

	private $con;

	function __construct(){
		require_once dirname(__FILE__).'/DBConnect.php';

		$db = new DBConnect();

		$this->con = $db->connect();

	}
	
	function getSMTPEmail(){
	    $get_email = $this->con->prepare("SELECT * FROM smtp_gmail_guide ORDER BY smtp_id DESC LIMIT 1;");
	    $get_email->execute();
	    $result = $get_email->get_result()->fetch_assoc();
	    return $result;
	}

	function calculateInternAddedHours($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$hrs_added = $this->con->prepare("SELECT SUM(hrs_today) AS hrs_added FROM attendance WHERE user_acc_id = ?");
		$hrs_added->bind_param('i', $userID);
		$hrs_added->execute();
		$result = $hrs_added->get_result()->fetch_assoc();
		return $result;
	}

	function calculateInternPenaltyHours($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];
		$status = "Penalty";

		$hrs_added = $this->con->prepare("SELECT SUM(hours_added) AS penalty_hours FROM hours_added WHERE user_acc_id = ? AND deducted_penalty = ?");
		$hrs_added->bind_param('is', $userID, $status);
		$hrs_added->execute();
		$result = $hrs_added->get_result()->fetch_assoc();
		return $result;
	}

	function calculateInternDeductedHours($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];
		$status = "Deducted";

		$hrs_added = $this->con->prepare("SELECT SUM(hours_added) AS deducted_hours FROM hours_added WHERE user_acc_id = ? AND deducted_penalty = ?");
		$hrs_added->bind_param('is', $userID, $status);
		$hrs_added->execute();
		$result = $hrs_added->get_result()->fetch_assoc();
		return $result;
	}

	function calculateInternHoursLeft($email, $requiredHours){
		$hrs_added = $this->calculateInternAddedHours($email);
		$penalty_hours = $this->calculateInternPenaltyHours($email);
		$deducted_hours = $this->calculateInternDeductedHours($email);

		$hrs_added = round($hrs_added['hrs_added'],1);
		$penalty_hours = $penalty_hours['penalty_hours'];
		$deducted_hours = $deducted_hours['deducted_hours'];

		return $requiredHours - $hrs_added - $deducted_hours + $penalty_hours;
	}

	function getAttendanceMaxID($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$getID = $this->con->prepare("SELECT MAX(att_id) AS max_id FROM attendance WHERE user_acc_id = ?");
		$getID->bind_param('i', $userID);
		$getID->execute();
		$result = $getID->get_result()->fetch_assoc();
		return $result;

	}

	function getRemainingHours($email){
		$maxID = $this->getAttendanceMaxID($email);

		$get_hours_left = $this->con->prepare("SELECT * FROM attendance WHERE att_id = ?");
		$get_hours_left->bind_param('i', $maxID['max_id']);
		$get_hours_left->execute();
		$result = $get_hours_left->get_result()->fetch_assoc();
		return $result;
	}

	function checkShiftSchedule($email, $dayToday){
		$check_shift = $this->con->prepare("SELECT schedule FROM intern_info WHERE username = ?");
		$check_shift->bind_param('s', $email);
		$check_shift->execute();
		$check_shift->bind_result($userSchedule);

		while($check_shift->fetch()){
			$shift = $userSchedule;
		}

		$shiftList = array();
		$shiftList = explode("/", $shift);

		if(in_array($dayToday, $shiftList)){
			return true;
		}else{
			return false;
		}

	}

	function validateInternStatus($email){
		$check_status = $this->con->prepare("SELECT * FROM intern_info WHERE username = ?");
		$check_status->bind_param('s',$email);
		$check_status->execute();
		$result = $check_status->get_result()->fetch_assoc();
		return $result;
	}

	function validateUserType($email){
		$userType = "Intern";
		$check_user_type = $this->con->prepare("SELECT * FROM user_acc WHERE username = ? AND usertype = ?");
		$check_user_type->bind_param('ss', $email, $userType);
		$check_user_type->execute();
		$check_user_type->store_result();
		return $check_user_type->num_rows > 0;
	}


	function isUserExist($email){
		$check_email = $this->con->prepare("SELECT * FROM user_acc WHERE username = ?");
		$check_email->bind_param('s',$email);
		$check_email->execute();
		$check_email->store_result();
		return $check_email->num_rows > 0;
	}

	function verifyLogin($email, $password){
		$check_email = $this->con->prepare("SELECT * FROM user_acc WHERE username = ? AND passwd = ?");
		$check_email->bind_param('ss',$email, $password);
		$check_email->execute();
		$check_email->store_result();
		return $check_email->num_rows > 0;
	}

	function isUserAccepted($email){
		$check_email = $this->con->prepare("SELECT * FROM user_acc WHERE username = ?");
		$check_email->bind_param('s',$email);
		$check_email->execute();
		$result = $check_email->get_result()->fetch_assoc();
		return $result;
	}

	function getUserID($email){
		$stmt = $this->con->prepare("SELECT * FROM user_acc WHERE username = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		return $result;

	}

	function changePassword($email, $password){
		$date = date('Y-m-d');
		$password = md5($this->con->real_escape_string($password));
		
		$change_password = $this->con->prepare("UPDATE user_acc SET passwd= ?, password_updated = ? WHERE username = ?");
		$change_password->bind_param('sss', $password, $date, $email);
		if($change_password->execute()){
			return 0; //success
		}else{
			return 1; //db error
		}

	}

	function verifyOldPassword($email, $password){
		$password = md5($this->con->real_escape_string($password));

		$verify_password = $this->con->prepare("SELECT * FROM user_acc WHERE username = ?");
		$verify_password->bind_param('s', $email);
		$verify_password->execute();
		$result = $verify_password->get_result()->fetch_assoc();

		if($result['passwd'] == $password){
			return true;
		}else{
			return false;
		}
	}

	/**************** REGISTER INTERFACE ***************/
	function getShift($startTime){
		if($startTime == "8:00 AM"){
			return "1";
		}else if($startTime == "9:00 AM"){
			return "2";
		}else{
			return "3";
		}
	}

	function registerUserData($userData){
		
		$insert_data = $this->con->prepare("INSERT INTO user_acc(firstname,lastname, middle_name, username, passwd, usertype, shift, position, permission, last_login, date_registered, profile_pic) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$insert_data->bind_param('sssssssssiss', $userData['first_name'], $userData['last_name'], $userData['middle_name'], $userData['email'], $userData['password'], $userData['usertype'], $userData['shift'], $userData['position'], $userData['permission'], $userData['last_login'], $userData['date_registered'], $userData['profile_pic']);
		$insert_data->execute();
		$insert_data->close();

		$insert_info = $this->con->prepare("INSERT INTO intern_info(username, app_id, street, barangay, city, province, birthdate, mobile_no, sex, religion, civil_status, school, company, department, intern_status, startdate, required_hours, gdrive_link, estimated_end_date, start_shift, end_shift, schedule) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$insert_info->bind_param('ssssssssssssssssssssss', $userData['email'], $userData['app_id'], $userData['street'], $userData['barangay'], $userData['city'], $userData['province'], $userData['birthdate'], $userData['mobile_no'], $userData['sex'], $userData['religion'], $userData['civil_status'], $userData['school'], $userData['company'], $userData['department'], $userData['intern_status'], $userData['start_date'], $userData['required_hrs'], $userData['gdrive_link'], $userData['end_date'], $userData['start_shift'], $userData['end_shift'], $userData['schedule']);
		if($insert_info->execute()){
			return true;
		}else{
			return false;
		}

	}

	/**************************************************/

	/****************** LOGIN PAGE ********************/
	function loginUser($email, $password){
		$password = md5($this->con->real_escape_string($password));
		$isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

		if($isValidEmail){
			if($this->isUserExist($email)){

				$permission = $this->isUserAccepted($email);

				if($permission['permission'] == 1){
					if($this->validateUserType($email)){
						$status = $this->validateInternStatus($email);

						if($status['intern_status'] == "Terminated"){
							return 3; // terminated
						}else if($status['intern_status'] == "Completed"){
							return 2; // completed
						}else{

							if($this->verifyLogin($email, $password)){
								return 0; //success
						
							}else{
								return 1;//Username or password is incorrect.
							}
						}

							
					}else{
						return 4;//user is not an intern 
					}
					
				}else if($permission['permission'] == 0){
					return 5; //pending
				}else{
					return 6; //rejected
				}

			}else{
				return 7;//user does not exist
			}
		}else{
			return 8; //invalid email
		}
	}

	/**************************************************/

	/***********FORGOT PASSWORD INTERFACE *************/
	function sendVerificationCode($email){
		if($this->isUserExist($email)){
			$get_data = $this->getUserID($email);

			date_default_timezone_set("Asia/Manila");
			$date_today = date('Y-m-d');

			if($get_data['password_updated'] == $date_today){
				return 1; // limit
			}else{

				$code = rand(999999, 111111);
				$insert_code = $this->con->prepare("INSERT INTO resetpasswords(code, email) VALUES(?,?)");
				$insert_code->bind_param('ss', $code, $email);
				if($insert_code->execute()){

				    return $code;
				}else{
					return 2; // db-error
				}

			}

		}else{
			return 3; //user does not exist
		}

	}

	function deleteUserVerificationData($email){
		$delete_data = $this->con->prepare("DELETE FROM resetpasswords WHERE email = ?");
		$delete_data->bind_param('s', $email);
		if($delete_data->execute()){
			return 0; // delete success
		}else{
			return 1; // db-error
		}

	}

	/**************************************************/

	/************* USER PROFILE INTERFACE *************/

	function getUserData($email){

		$get_data = $this->con->prepare("SELECT * FROM user_acc WHERE username = ?");
		$get_data->bind_param('s', $email);
		$get_data->execute();
		$result = $get_data->get_result()->fetch_assoc();
		return $result;

	}

	function getUserBasicInfo($email){

		$get_data = $this->con->prepare("SELECT * FROM intern_info WHERE username = ?");
		$get_data->bind_param('s', $email);
		$get_data->execute();
		$result = $get_data->get_result()->fetch_assoc();
		return $result;

	}

	function updateUserProfile($email, $inputs){

		$update_data = $this->con->prepare("UPDATE intern_info
			SET street = ?, barangay = ?, city = ?, province = ?, mobile_no = ?, gdrive_link = ? WHERE username = ?");
		$update_email = $this->con->prepare("UPDATE user_acc SET username = ? WHERE username = ?");

		$update_data->bind_param('sssssss', $inputs['street'], $inputs['barangay'], $inputs['city'], $inputs['province'], $inputs['contact_number'],  $inputs['drive'], $email);
		$update_email->bind_param('ss', $inputs['email'], $email);

		if($update_data->execute() && $update_email->execute()){
			return 0; //succeess
		}else{
			return 1; //db-error
		}

	}

	/**************************************************/

	/************** ANNOUNCEMENTS CARDVIEW ************/
	function getAnnouncements($email){
		date_default_timezone_set("Asia/Manila");
		$participated_webinar = $this->getInternWebinar($email);
		if($participated_webinar){
			$participated_webinar = $participated_webinar[0];
		}
			



		$get_announce = $this->con->prepare("SELECT * FROM webinar");
		$get_announce->execute();
		$get_announce->bind_result($webinarID, $userID, $title, $description, $link, $speaker, $dateOfMeeting, $time, $regFee, $datePosted, $webStatus);

		$result = array();

		while($get_announce->fetch()){
			$temp = array();
			$dateOfMeeting = new DateTime($dateOfMeeting);
			$datePosted = new DateTime($datePosted);
			$dateOfMeeting = $dateOfMeeting->format('F j, Y');
			$datePosted = $datePosted->format('F j, Y');

			$temp['participated'] = (in_array($webinarID, $participated_webinar) ? true : false);
			$temp['webinarID'] = $webinarID; 
			$temp['authorID'] = $userID;
			$temp['title'] = $title;
			$temp['details'] = $description;
			$temp['speaker'] = $speaker;
			$temp['meeting_link'] = $link;
			$temp['meeting_date'] = $dateOfMeeting;
			$temp['meeting_time'] = $time;
			$temp['registration_fee'] = $regFee;
			$temp['date_posted'] = $datePosted;
			$temp['webinar_status'] = (($webStatus == 1) ? "Open" : "Close");

			array_push($result, $temp);
		}

		return $result;
	}
	/**************************************************/

	/************* USER TIME-IN/TIME-OUT **************/
	function checkUserTimeLogs($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];
		$date = date('Y-m-d');

		$check_logs = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? AND date_in = ?");
		$check_logs->bind_param('is', $userID, $date);
		$check_logs->execute();
		$check_logs->store_result();
		if($check_logs->num_rows > 0){
			$check_logs->close();

			$check_logs = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? AND date_in = ?");
			$check_logs->bind_param('is', $userID, $date);
			$check_logs->execute();
			$result = $check_logs->get_result()->fetch_assoc();
			return $result;
		}else{
			return 1;
		}
	}

	function userTimeIn($email, $startShift, $company, $requiredHours){
		date_default_timezone_set("Asia/Manila");
		$status = $this->validateInternStatus($email);
		$date = date("Y-m-d"); //YYYY-MM-DD
		$startShift = date("H:i", strtotime($startShift));
		$early = date("H:i", strtotime($startShift) - (15*60));// 7:45
		$late_1hr = date("H:i", strtotime($startShift) + (15*60)); //8:15am
		$late_1hr2 = date("H:i", strtotime($startShift) + (30*60)); //8:30am
		$late_2hrs = date("H:i", strtotime($startShift) + (120*60)); //10:00am
		$time = date("H:i");
		$day = date("l");
		$message = "Time in Successful";

		if($status['intern_status'] == 'Offboarding'){
			return "offboard";
		}else{

			if($this->checkShiftSchedule($email, $day)){
				if($time < $early){
					return "early";
				}else{
					if($time >= $early && $time <= $late_1hr){
						$remarks = "On Time";
					}else if($time > $late_1hr && $time <= $late_1hr2){
						$remarks = "1 hr late";
					}else if($time > $late_1hr2 && $time <= $late_2hrs){
						$remarks = "2 hrs late";
					}else{
						$remarks = "Absent";
					}

					$user = $this->getUserID($email);
					$userID = $user['user_acc_id'];

					$hrs_left = $this->calculateInternHoursLeft($email, $requiredHours);

					if($remarks == "Absent"){
						return "late";
					}else{
						$time = date("H:i", strtotime($time));
						$insert_log = $this->con->prepare("INSERT INTO attendance(user_acc_id, company, date_in, time_in, hrs_left, remark_time_in, remark) VALUES(?, ?, ?, ?, ?)");
						$insert_log->bind_param('isssiss', $userID, $company, $date, $time, $hrs_left, $remarks, $message);
						if($insert_log->execute()){
							$last_id = $insert_log->insert_id;
							$insert_log->close();

							return $last_id;
						}else{
							return false;
						}
					}
				}

			}else{
				return "no_shift";
			}

		}
		
	}

	function timeVoided($email, $last_id, $requiredHours){
		$day = date("l", strtotime("yesterday"));
		$date = "0000-00-00";
		$time = "00:00";
		$hrs = 0;
		$message = "Time out Successful";

		if($last_id != 0){
			$update_log = $this->con->prepare("UPDATE attendance SET date_out = ?, time_out = ?, hrs_today = ? WHERE att_id = ?");
			$update_log->bind_param('ssdi', $date, $time, $hrs, $last_id);
			if($update_log->execute()){
				$update_log->close();

				$hrs_added = $this->calculateInternAddedHours($email);
				$hrs_added = round($hrs_added['hrs_added'],1);
				$hrs_left = $this->calculateInternHoursLeft($email, $requiredHours);

				$update_log = $this->con->prepare("UPDATE attendance SET hrs_added = ?, hrs_left =?, remark=? WHERE att_id = ?");
				$update_log->bind_param('disi', $hrs_added, $hrs_left, $message, $last_id);
				if($update_log->execute()){
					return true;
				}else{
					return false;
				}

			}else{
				return false;
			}
		}else{
			return "reset";
		}/*else{
			if($this->checkShiftSchedule($email, $day)){
				$user = $this->getUserID($email);
				$userID = $user['user_acc_id'];
				$date = date('Y-m-d');
				$time = date('H:i');
				$remarks = "Absent";
				$hrs = 0;
				$message = "Time out Successful";

				$insert_log = $this->con->prepare("INSERT INTO attendance(user_acc_id, date_in, time_in, date_out, time_out, hrs_today, hrs_added, remark_time_in, remark) VALUES (?,?,?,?,?,?,?,?,?)");
				$insert_log->bind_param('issssddss', $userID, $date, $time, $date, $time,$hrs, $hrs, $remarks, $message);

			}
		}*/
		
	}

	function lateTimeIn($email, $company, $requiredHours){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];
		$date = date('Y-m-d');
		$time = date('H:i');
		$remarks = "Absent";
		$hrs = 0;
		$message = "Time out Successful";

		$hrs_left = $this->calculateInternHoursLeft($email, $requiredHours);

		$insert_log = $this->con->prepare("INSERT INTO attendance(user_acc_id, company, date_in, time_in, date_out, time_out, hrs_today, remark_time_in) VALUES (?,?,?,?,?,?,?,?)");
		$insert_log->bind_param('isssssds', $userID, $company, $date, $time, $date, $time,$hrs, $remarks);
		if($insert_log->execute()){
			$last_id = $insert_log->insert_id;
			$insert_log->close();

			$hrs_added = $this->calculateInternAddedHours($email);
			$hrs_added = round($hrs_added['hrs_added'],1);
			$hrs_left = $this->calculateInternHoursLeft($email, $requiredHours);

			$update_log = $this->con->prepare("UPDATE attendance SET hrs_added = ?, hrs_left =?, remark=? WHERE att_id = ?");
			$update_log->bind_param('disi', $hrs_added, $hrs_left, $message, $last_id);
			if($update_log->execute()){
				return true;
			}else{
				return false;
			}
		}
	}

	function userTimeOut($email, $last_id, $endShift, $requiredHours){
		$closeTimeout = date("H:i", strtotime($endShift) + (25*60));

		$get_data = $this->con->prepare("SELECT * FROM attendance WHERE att_id = ?");
		$get_data->bind_param('i', $last_id);
		$get_data->execute();
		$data = $get_data->get_result()->fetch_assoc();
		$get_data->close();

		date_default_timezone_set("Asia/Manila");
		$date = date("Y-m-d"); //YYYY-MM-DD
		$time = date("H:i");

		$timeIn = strtotime($data['time_in']);
		$timeOut = strtotime($time);

		$hrs = round(abs($timeOut - $timeIn) / 3600, 1);
		if($data['remark_time_in'] == "On time"){
			$hrs = $hrs - 1;
		}else if($data['remark_time_in'] == "1 hr late"){
			$hrs = $hrs - 2;
		}else{
			$hrs = $hrs - 3;
		}

		if($hrs < 0){
			$hrs = 0;
		}else if($hrs > 8){
		    $hrs = 8;
		}

		$message = "Time out Successful";

		if($time >= $closeTimeout){
			return 0;
		}else{
			$update_log = $this->con->prepare("UPDATE attendance SET date_out = ?, time_out = ?, hrs_today = ? WHERE att_id = ?");
			$update_log->bind_param('ssdi', $date, $time, $hrs, $last_id);
			if($update_log->execute()){
				$update_log->close();
				$hrs_added = $this->calculateInternAddedHours($email);
				$hrs_added = round($hrs_added['hrs_added'],1);
				$hrs_left = $this->calculateInternHoursLeft($email, $requiredHours);

				$update_log = $this->con->prepare("UPDATE attendance SET hrs_added = ?, hrs_left =?, remark=? WHERE att_id = ?");
				$update_log->bind_param('disi', $hrs_added, $hrs_left, $message, $last_id);
				if($update_log->execute()){
					return true;
				}else{
					return false;
				}


				
			}else{
				return false;
			}
		}

		


	}


	function getAttendanceLog($email, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		if($filter == "ASC"){
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? ORDER BY att_id ASC");
		}else if($filter == "DESC"){
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? ORDER BY att_id DESC");
		}else{
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ?");
		}
		$get_attendance_log->bind_param('i', $userID);
		$get_attendance_log->execute();
		$get_attendance_log->bind_result($attendanceID, $userAccountID, $company, $date_in, $time_in, $date_out, $time_out, $hrs_today, $hrs_left, $hrs_added, $timeRemarks, $attendanceRemarks);

		$result = array();

		while($get_attendance_log->fetch()){
			$temp = array();
			$date_in = new DateTime($date_in);
			$time_in = new DateTime($time_in);
			$time_out = new DateTime($time_out);

			$day = $date_in->format('l');
			$date_in = $date_in->format('F j, Y');
			$time_in = $time_in->format('g:i a');
			$time_out = $time_out->format('g:i a');


			$temp['date_in'] = $date_in;
			$temp['day'] = $day;
			$temp['time_in'] = $time_in;
			$temp['time_out'] = $time_out;
			$temp['remarks'] = $timeRemarks;
	

			array_push($result, $temp);
		}

		return $result;

	}

	function getAttendanceLogBySearch($email, $search, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$concatSearch = "%".$search."%";
		$search_date = "";
		if(strtotime($search)){
			$date = new DateTime($search);
			$search_date = $date->format('Y-m-d');
		}

		if($filter == "ASC"){
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? AND (date_in = ? OR remark_time_in LIKE ? OR MONTHNAME(date_in) LIKE ? OR YEAR(date_in) LIKE ? OR DAYNAME(date_in) LIKE ?) ORDER BY att_id ASC");
		}else if($filter == "DESC"){
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? AND (date_in = ? OR remark_time_in LIKE ? OR MONTHNAME(date_in) LIKE ? OR YEAR(date_in) LIKE ? OR DAYNAME(date_in) LIKE ?) ORDER BY att_id DESC");
		}else{
			$get_attendance_log = $this->con->prepare("SELECT * FROM attendance WHERE user_acc_id = ? AND (date_in = ? OR remark_time_in LIKE ? OR MONTHNAME(date_in) LIKE ? OR YEAR(date_in) LIKE ? OR DAYNAME(date_in) LIKE ?)");
		}
		
		
		$get_attendance_log->bind_param('isssss', $userID, $search_date, $concatSearch, $concatSearch, $concatSearch, $concatSearch);
		$get_attendance_log->execute();
		$get_attendance_log->bind_result($attendanceID, $userAccountID, $company, $date_in, $time_in, $date_out, $time_out, $hrs_today, $hrs_left, $hrs_added, $timeRemarks, $attendanceRemarks);

		$result = array();

		while($get_attendance_log->fetch()){
			$temp = array();
			$date_in = new DateTime($date_in);
			$time_in = new DateTime($time_in);
			$time_out = new DateTime($time_out);

			$day = $date_in->format('l');
			$date_in = $date_in->format('F j, Y');
			$time_in = $time_in->format('g:i a');
			$time_out = $time_out->format('g:i a');


			$temp['date_in'] = $date_in;
			$temp['day'] = $day;
			$temp['time_in'] = $time_in;
			$temp['time_out'] = $time_out;
			$temp['remarks'] = $timeRemarks;
	

			array_push($result, $temp);
		}

		return $result;

	}

	

	/**************************************************/

	/**************** PROJECT STATUS *****************/

	function insertProjectStatus($email, $inputs){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$insert_data = $this->con->prepare("INSERT INTO project (user_acc_id, task_name, file_formats, date_assigned, date_submitted, status, gdrive_link) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$insert_data->bind_param('issssss', $userID, $inputs['task_name'], $inputs['file_format'], $inputs['date_assigned'], $inputs['date_submitted'], $inputs['status'], $inputs['gdrive_link']);

		if($insert_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	function deleteProjectStatus($statusID){
		$delete_data = $this->con->prepare("DELETE FROM project WHERE project_id = ?");
		$delete_data->bind_param('i', $statusID);

		if($delete_data->execute()){
			return true;
		}else{
			return false;
		}
	}
	function getProjectStatusBySearch($email, $search, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];


		$concatSearch = "%".$search."%";
		$search_date = "";
		if(strtotime($search)){
			$date = new DateTime($search);
			$search_date = $date->format('Y-m-d');
		}

		if ($filter == "ASC") {
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ? AND (task_name LIKE ? OR file_formats LIKE ? OR MONTHNAME(date_assigned) LIKE ? OR DAYNAME(date_assigned) LIKE ? OR YEAR(date_assigned) LIKE ? OR date_assigned = ?) ORDER BY project_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ? AND (task_name LIKE ? OR file_formats LIKE ? OR MONTHNAME(date_assigned) LIKE ? OR DAYNAME(date_assigned) LIKE ? OR YEAR(date_assigned) LIKE ? OR date_assigned = ?) ORDER BY project_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ? AND (task_name LIKE ? OR file_formats LIKE ? OR MONTHNAME(date_assigned) LIKE ? OR DAYNAME(date_assigned) LIKE ? OR YEAR(date_assigned) LIKE ? OR date_assigned = ?)");
		}

		
		$get_data->bind_param('issssss', $userID, $concatSearch, $concatSearch, $concatSearch, $concatSearch, $concatSearch, $search_date);
		$get_data->execute();
		$get_data->bind_result($projectID, $userID, $projectName, $dateAssigned, $dateSubmitted, $fileFormat, $status, $googleDriveLink);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$dateSubmitted = new DateTime($dateSubmitted);
			$dateSubmitted = $dateSubmitted->format('F j, Y');

			$dateAssigned = new DateTime($dateAssigned);
			$dateAssigned = $dateAssigned->format('F j, Y');

			$temp['project_id'] = $projectID;
			$temp['project_name'] = $projectName;
			$temp['file_format'] = $fileFormat;
			$temp['date_assigned'] = $dateAssigned;
			$temp['date_submitted'] = $dateSubmitted;
			$temp['status'] = $status;
			$temp['google_drive_link'] = $googleDriveLink;

			array_push($result, $temp);
		}
		return $result;

	}

	function getProjectStatus($email, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ? ORDER BY project_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ? ORDER BY project_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM project WHERE user_acc_id = ?");
		}
		
		$get_data->bind_param('i', $userID);
		$get_data->execute();
		$get_data->bind_result($projectID, $userID, $projectName, $dateAssigned, $dateSubmitted, $fileFormat, $status, $googleDriveLink);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$dateSubmitted = new DateTime($dateSubmitted);
			$dateSubmitted = $dateSubmitted->format('F j, Y');

			$dateAssigned = new DateTime($dateAssigned);
			$dateAssigned = $dateAssigned->format('F j, Y');

			$temp['project_id'] = $projectID;
			$temp['project_name'] = $projectName;
			$temp['file_format'] = $fileFormat;
			$temp['date_assigned'] = $dateAssigned;
			$temp['date_submitted'] = $dateSubmitted;
			$temp['status'] = $status;
			$temp['google_drive_link'] = $googleDriveLink;

			array_push($result, $temp);
		}
		return $result;
		
	}

	function updateProjectStatus($projectID, $userData){
		$update_data = $this->con->prepare("UPDATE project 
			SET task_name = ?, file_formats = ?, date_assigned = ?, gdrive_link = ?
			WHERE project_id = ?");
		$update_data->bind_param('ssssi', $userData['task_name'], $userData['file_format'], $userData['date_assigned'], $userData['gdrive_link'], $projectID);
		if($update_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	/**************************************************/

	/**************** REPORT *****************/

	function insertReport($email, $inputs){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$insert_data = $this->con->prepare("INSERT INTO intern_report (ticket_no, user_acc_id, report_subject, report_details, gdrive_link, report_status, date_reported) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$insert_data->bind_param('sisssss',$inputs['ticket_no'], $userID, $inputs['report_subject'], $inputs['report_details'], $inputs['gdrive_link'], $inputs['report_status'], $inputs['date_submitted']);

		if($insert_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	function deleteReport($reportID){
		$delete_data = $this->con->prepare("DELETE FROM intern_report WHERE report_id = ?");
		$delete_data->bind_param('i', $reportID);

		if($delete_data->execute()){
			return true;
		}else{
			return false;
		}
	}
	function getReportBySearch($email, $search, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];


		$concatSearch = "%".$search."%";

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ? AND (report_subject LIKE ? OR report_status LIKE ? OR ticket_no LIKE ?) ORDER BY report_id ASC ");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ? AND (report_subject LIKE ? OR report_status LIKE ? OR ticket_no LIKE ?) ORDER BY report_id DESC ");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ? AND (report_subject LIKE ? OR report_status LIKE ? OR ticket_no LIKE ?)");
		}

		
		$get_data->bind_param('isss', $userID, $concatSearch, $concatSearch, $concatSearch);
		$get_data->execute();
		$get_data->bind_result($reportID, $ticketNo, $userID, $reportSubject, $reportDetails, $gDriveLink, $reportStatus, $dateReported, $dateFixed);

		$result = array();

		while($get_data->fetch()){
			$temp = array();

			$temp['report_id'] = $reportID;
			$temp['ticket_no'] = $ticketNo;
			$temp['report_title'] = $reportSubject;
			$temp['report_details'] = $reportDetails;
			$temp['gdrive_link'] = $gDriveLink;
			$temp['report_status'] = $reportStatus;
			$temp['dateReport'] = $dateReported;

			array_push($result, $temp);
		}
		return $result;

	}

	function getReport($email, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ? ORDER BY report_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ? ORDER BY report_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM intern_report WHERE user_acc_id = ?");
		}
		
		$get_data->bind_param('i', $userID);
		$get_data->execute();
		$get_data->bind_result($reportID, $ticketNo, $userID, $reportSubject, $reportDetails, $gDriveLink, $reportStatus, $dateReported, $dateFixed);

		$result = array();

		while($get_data->fetch()){
			$temp = array();

			$temp['report_id'] = $reportID;
			$temp['ticket_no'] = $ticketNo;
			$temp['report_title'] = $reportSubject;
			$temp['report_details'] = $reportDetails;
			$temp['gdrive_link'] = $gDriveLink;
			$temp['report_status'] = $reportStatus;
			$temp['dateReport'] = $dateReported;

			array_push($result, $temp);
		}
		return $result;
		
	}

	function updateReport($reportID, $userData){
		$update_data = $this->con->prepare("UPDATE intern_report
			SET report_subject = ?, report_details = ?, gdrive_link = ?
			WHERE report_id = ?");
		$update_data->bind_param('sssi', $userData['report_title'], $userData['report_details'], $userData['report_documents'], $reportID);
		if($update_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	/**************************************************/

	/**************** LEAVE STATUS *****************/

	function insertLeave($email, $inputs){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$insert_data = $this->con->prepare("INSERT INTO intern_leave (user_acc_id, reason_leave, leave_from, leave_to, leave_type, leave_status) VALUES (?, ?, ?, ?, ?, ?)");
		$insert_data->bind_param('isssss', $userID, $inputs['leave_reason_details'], $inputs['date_start'], $inputs['date_end'], $inputs['leave_reason'], $inputs['leave_status']);

		if($insert_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	function deleteLeave($leaveID){
		$delete_data = $this->con->prepare("DELETE FROM intern_leave WHERE leave_id = ?");
		$delete_data->bind_param('i', $leaveID);

		if($delete_data->execute()){
			return true;
		}else{
			return false;
		}
	}
	function getLeaveBySearch($email, $search, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];


		$concatSearch = "%".$search."%";

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ? AND (leave_type LIKE ? OR leave_status LIKE ?)ORDER BY leave_id ASC ");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ? AND (leave_type LIKE ? OR leave_status LIKE ?) ORDER BY leave_id DESC ");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ? AND (leave_type LIKE ? OR leave_status LIKE ?) ");
		}

		
		$get_data->bind_param('iss', $userID, $concatSearch, $concatSearch);
		$get_data->execute();
		$get_data->bind_result($leaveID, $userID, $leaveDetails, $startDate, $endDate, $leaveReason, $leaveStatus);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$startDate = new DateTime($startDate);
			$startDate = $startDate->format('F j, Y');

			$endDate = new DateTime($endDate);
			$endDate = $endDate->format('F j, Y');

			if($leaveStatus == 0){
				$leaveStatus = "Pending";
			}else if($leaveStatus == 1){
				$leaveStatus = "Accepted";
			}else{
				$leaveStatus = "Rejected";
			}

			$temp['leave_report_id'] = $leaveID;
			$temp['leave_reason'] = $leaveReason;
			$temp['leave_reason_details'] = $leaveDetails;
			$temp['date_start'] = $startDate;
			$temp['date_end'] = $endDate;
			$temp['leave_status'] = $leaveStatus;

			array_push($result, $temp);
		}
		return $result;

	}

	function getLeave($email, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ? ORDER BY leave_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ? ORDER BY leave_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM intern_leave WHERE user_acc_id = ?");
		}
		
		$get_data->bind_param('i', $userID);
		$get_data->execute();
		$get_data->bind_result($leaveID, $userID, $leaveDetails, $startDate, $endDate, $leaveReason, $leaveStatus);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$startDate = new DateTime($startDate);
			$startDate = $startDate->format('F j, Y');

			$endDate = new DateTime($endDate);
			$endDate = $endDate->format('F j, Y');

			if($leaveStatus == 0){
				$leaveStatus = "Pending";
			}else if($leaveStatus == 1){
				$leaveStatus = "Accepted";
			}else{
				$leaveStatus = "Rejected";
			}

			$temp['leave_report_id'] = $leaveID;
			$temp['leave_reason'] = $leaveReason;
			$temp['leave_reason_details'] = $leaveDetails;
			$temp['date_start'] = $startDate;
			$temp['date_end'] = $endDate;
			$temp['leave_status'] = $leaveStatus;

			array_push($result, $temp);
		}
		return $result;
		
	}

	function updateLeave($leaveID, $userData){
		$update_data = $this->con->prepare("UPDATE intern_leave
			SET leave_type = ?, reason_leave = ?, leave_from = ?, leave_to = ?
			WHERE leave_id = ?");
		$update_data->bind_param('ssssi', $userData['leave_reason'], $userData['leave_reason_details'], $userData['date_start'], $userData['date_end'], $leaveID);
		if($update_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	/**************************************************/

	/******************** WEBINAR *********************/

	function insertWebinar($email, $userData){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$insert_webinar = $this->con->prepare("INSERT INTO attended_webinar(attended_webinar_id, parti_user_acc_id, mode_of_payment, screenshot, status_payment, date_applied) VALUES (?, ?, ?, ?, ?,?)");
		$insert_webinar->bind_param('iissss', $userData['webinar_id'], $userID, $userData['mop'], $userData['pop'], $userData['status'], $userData['date_applied']);
		if($insert_webinar->execute()){
			return true;
		}else{
			return false;
		}
	}

	function getInternWebinar($email){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$get_webinars = $this->con->prepare("SELECT * FROM attended_webinar WHERE parti_user_acc_id = ?");
		$get_webinars->bind_param('i', $userID);
		$get_webinars->execute();
		$get_webinars->bind_result($attWebID, $webinarID, $userID, $mop, $pop, $status, $dateApplied);

		$result = array();

		while($get_webinars->fetch()){

			$temp['webinarID'] = $webinarID; 

			array_push($result, $temp);
		}

		return $result;
	}

	/**************************************************/
/**************** UNIVERSITY DOC STATUS *****************/

	function insertUniDocStatus($email, $inputs){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		$insert_data = $this->con->prepare("INSERT INTO university_documents (user_acc_id, document_title, coordinator_name, coordinator_email, date_submitted, deadline, file_format,  gdrive_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$insert_data->bind_param('issssssss', $userID, $inputs['document_title'],$inputs['coordinator_name'],$inputs['coordinator_email'], $inputs['date_submitted'], $inputs['deadline'], $inputs['file_format'],$inputs['gdrive_link'], $inputs['status']);

		if($insert_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	function deleteUniDocStatus($documentID){
		$delete_data = $this->con->prepare("DELETE FROM university_documents WHERE document_id = ?");
		$delete_data->bind_param('i', $documentID);

		if($delete_data->execute()){
			return true;
		}else{
			return false;
		}
	}

	function getUniDocStatusBySearch($email, $search, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];


		$concatSearch = "%".$search."%";
		$search_date = "";
		if(strtotime($search)){
			$date = new DateTime($search);
			$search_date = $date->format('Y-m-d');
		}

		if ($filter == "ASC") {
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ? AND (document_title LIKE ? OR file_format LIKE ? OR MONTHNAME(date_submitted) LIKE ? OR DAYNAME(date_submitted) LIKE ? OR YEAR(date_submitted) LIKE ? OR date_submitted = ?) ORDER BY document_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ? AND (document_title LIKE ? OR file_format LIKE ? OR MONTHNAME(date_submitted) LIKE ? OR DAYNAME(date_submitted) LIKE ? OR YEAR(date_submitted) LIKE ? OR date_submitted = ?) ORDER BY document_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ? AND (document_title LIKE ? OR file_format LIKE ? OR MONTHNAME(date_submitted) LIKE ? OR DAYNAME(date_submitted) LIKE ? OR YEAR(date_submitted) LIKE ? OR date_submitted = ?)");
		}

		
		$get_data->bind_param('issssss', $userID, $concatSearch, $concatSearch, $concatSearch, $concatSearch, $concatSearch, $search_date);
		$get_data->execute();
		$get_data->bind_result($documentID, $userID, $documentTitle, $coordinatorName, $coordinatorEmail, $dateSubmitted, $deadLine, $fileFormat, $status, $googleDriveLink);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$dateSubmitted = new DateTime($dateSubmitted);
			$dateSubmitted = $dateSubmitted->format('F j, Y');

			$deadLine = new DateTime($deadLine);
			$deadLine = $deadLine->format('F j, Y');

			
			$temp['document_id'] = $documentID;
			$temp['document_title'] = $documentTitle;
			$temp['coordinator_name'] = $coordinatorName;
			$temp['coordinator_email'] = $coordinatorEmail;
			$temp['file_format'] = $fileFormat;
			$temp['date_submitted'] = $dateSubmitted;
			$temp['deadline'] = $deadLine;
			$temp['status'] = $status;
			$temp['gdrive_link'] = $googleDriveLink;

			array_push($result, $temp);
		}
		return $result;

	}

	function getUniDocStatus($email, $filter){
		$user = $this->getUserID($email);
		$userID = $user['user_acc_id'];

		if($filter == "ASC"){
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ? ORDER BY document_id ASC");
		}else if($filter == "DESC"){
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ? ORDER BY document_id DESC");
		}else{
			$get_data = $this->con->prepare("SELECT * FROM university_documents WHERE user_acc_id = ?");
		}
		
		$get_data->bind_param('i', $userID);
		$get_data->execute();
		$get_data->bind_result($documentID, $userID, $documentTitle, $coordinatorName, $coordinatorEmail, $dateSubmitted, $deadLine, $fileFormat, $status, $googleDriveLink);

		$result = array();

		while($get_data->fetch()){
			$temp = array();
			$dateSubmitted = new DateTime($dateSubmitted);
			$dateSubmitted = $dateSubmitted->format('F j, Y');

			$deadLine = new DateTime($deadLine);
			$deadLine = $deadLine>format('F j, Y');

			
			$temp['document_id'] = $documentID;
			$temp['document_title'] = $documentName;
			$temp['file_format'] = $fileFormat;
			$temp['coordinator_name'] = $coordinatorName;
			$temp['coordinator_email'] = $coordinatorEmail;
			$temp['date_submitted'] = $dateSubmitted;
			$temp['deadline'] = $deadLine;
			$temp['status'] = $status;
			$temp['gdrive_link'] = $googleDriveLink;

			array_push($result, $temp);
		}
		return $result;
		
	}

	function updateUniDoctStatus($documentID, $userData){
		$update_data = $this->con->prepare("UPDATE university_documents
			SET document_title = ?, coordinator_name = ?, coordinator_email = ?, file_format = ?, date_submitted = ?, deadline = ?, gdrive_link = ?
			WHERE document_id = ?");
		$update_data->bind_param('sssssssi', $userData['document_title'], $userData['coordinator_name'], $userData['coordinator_email'], $userData['file_format'], $userData['date_submitted'], $userData['deadline'], $userData['gdrive_link'], $documentID);
		if($update_data->execute()){
			return true;
		}else{
			return false;
		}
	}

/**************************************************/



}

?>