<?php
	date_default_timezone_set('Asia/Manila');
	   
    include("db/dbconnection.php");
 
    $id = $_GET["id"];

    $sql = "UPDATE staff_info SET activity = 'Approving/Rejecting Intern Leave Application' WHERE username = '$id'";
    if (mysqli_query($conn, $sql)) {
        
    }
    
    $conn->close();

?>