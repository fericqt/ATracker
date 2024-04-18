<?php 



    $id = (int)$_GET['id']; 

   include("db/dbconnection.php");

    $query = "SELECT *

    FROM user_acc WHERE user_acc_id = '".$id."'";



    $result = $conn->query($query);

   

    

    while ($row = $result->fetch_array()) {

      

       

        $intern = $row["user_acc_id"]. "|" . strtoupper($row["firstname"]). "|" . strtoupper($row["middle_name"]). "|" . strtoupper($row["lastname"]). "|" . $row["profile_pic"];

        

        

    }

       

        echo $intern;

 $conn->close();

?>