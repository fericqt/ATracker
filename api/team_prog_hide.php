<?php
 $user_id = $_GET ['id'];
 include("db/dbconnection.php");
 
 $date = date_create()->format('Y-m-d');
 
 
 $sql = "SELECT * FROM team_proj_progress WHERE user_acc_id = ".$user_id." AND BINARY date_submitted ='".$date."' ORDER BY id DESC LIMIT 1";
 $result = $conn->query($sql);
 
 //echo "<script>console.log('Debug Objects: " .$date. "' );</script>";
 if($result->num_rows > 0){
     echo "1";//if rows exist
 }else{
     echo "2";// if null
 }
 $conn->close();
?>