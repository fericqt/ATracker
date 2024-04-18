<?php 

    $id = (int)$_GET['id']; 
   
    $query = "SELECT *
    FROM intern_info, user_acc WHERE intern_info.username=user_acc.username AND user_acc.user_acc_id = '".$id."'";

    $search_result= filterTable($query);
   
    
    while ($row = $search_result->fetch_assoc()) {
      
       
        $intern = $row["intern_info_id"]. "|" . $row["app_id"] . "|" . $row["firstname"] . "|" . $row["middle_name"] . "|" . $row["lastname"] . "|" . $row["street"] . "|" . $row["barangay"] . "|" . $row["city"] . "|" . $row["birthdate"] . "|" . $row["religion"] . "|" . $row["sex"] . "|" . $row["civil_status"] . "|". $row["username"]. "|" . $row["passwd"]. "|" . $row["company"] . "|" . $row["department"] . "|" . $row["intern_status"] . "|" . $row["startdate"] . "|" . $row["estimated_end_date"] . "|" .  $row["required_hours"] . "|" . $row["gdrive_link"];
        
       
    }
        echo $intern;
  
    
    function filterTable($query){
        $connect = mysqli_connect("localhost", "root", "", "a_tracker");
        $filter_Result = mysqli_query($connect, $query);
        
        return $filter_Result;
    }

?>