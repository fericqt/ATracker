<?php
    header("Content-Type: application/json; charset=UTF-8");

    include("db/dbconnection.php");
	
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $pwd = $conn->real_escape_string($_POST['pwd']);
    
    $sql = "SELECT * FROM user_acc WHERE BINARY username = '$user_name' AND BINARY passwd = '$pwd'";
    $result = $conn->query($sql);
    
    $response = array();
    
    if ($result->num_rows > 0) {
	  // output data of each row
	  if($row = $result->fetch_assoc()) {
		//echo $row["username"] . "|" . $row["password"] . "|" . $row["usertype"];
		//echo "1";
		array_push($response, $row);
	  }
	} else {
	  //echo "Access Denied";
	  //echo "0";
	  array_push($response, "Access Denied");
	}
	$conn->close();
	
	echo json_encode($response);
?>