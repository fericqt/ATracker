<?php 

    

    $id = (int)$_GET['id']; 

   

    $query = "SELECT *

    FROM intern_info, user_acc WHERE intern_info.username=user_acc.username AND user_acc.user_acc_id = '".$id."'";



    $search_result= filterTable($query);

   

    

    while ($row = $search_result->fetch_assoc()) {

     
        $intern = $row["firstname"] . "|" . $row["middle_name"] . "|" . $row["lastname"] . "|" . $row["street"] . "|" . $row["barangay"] . "|" . $row["city"]. "|" . $row["province"] . "|" . $row["birthdate"] . "|" . $row["religion"] . "|" . $row["sex"] . "|" . $row["civil_status"] . "|". $row["username"]. "|" . $row["mobile_no"]. "|" . $row["company"] . "|" . $row["department"] . "|" . $row["gdrive_link"] . "|" . $row["school"]. "|" . $row["schedule"];

        

       

    }

        echo $intern;

  

    

    function filterTable($query){

        $connect = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s", "u445178645_attendance");

        $filter_Result = mysqli_query($connect, $query);

        

        return $filter_Result;

    }



?>