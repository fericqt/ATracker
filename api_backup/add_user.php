<?php


	include("db/dbconnection.php");
	
    if(isset($_POST['usertype']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['middle_name']) && isset($_POST['email']) && isset($_POST['pwd'])){

        $usertype = $_POST['usertype'];
        $firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
        $middle_name = $_POST['middle_name'];
		$user_name = $_POST['email'];
		$pwd = $_POST['pwd'];
        $position = 0;
		$permission = 0;

		
		
		if(isset($_POST['email']))
		{
			$sql = "SELECT * FROM user_acc WHERE username='".$_POST['email']."'";
			$result = $conn->query($sql);
			
			if(mysqli_num_rows($result)>0)
			{
				echo '2';
			}
			else
			{
				$sql1 = "INSERT INTO user_acc (firstname, lastname, middle_name, username, passwd, usertype, position, permission) VALUES ('$firstname', '$lastname', '$middle_name', '$user_name', '$pwd', '$usertype', '$position', '$permission')";
				if ($conn->query($sql1) === TRUE) 
				{
					echo "1" ;			
			
				} else 
				{
					echo "0";
				}
			}

        }
        $conn->close();
    }
	

?>