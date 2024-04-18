<?php

	include("db/dbconnection.php");
	
    $id = $_POST['id'];
    $permission = 2;
    
   // sql to delete a record
   $sql = "UPDATE user_acc SET permission='$permission' where user_acc_id='$id'";
    
		
		if ($conn->query($sql) === TRUE) {
			echo "1";
		}
		else {
		  echo "0";
		}
     
    
    $conn->close();
?>