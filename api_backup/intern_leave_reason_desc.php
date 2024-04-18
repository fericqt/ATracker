<?php 

    $id = $_GET['id']; 
   
    $query = "SELECT *
    FROM intern_leave
    WHERE leave_id = '$id'";

    $search_result= filterTable($query);
	
    
    while ($row = $search_result->fetch_assoc()) {
		
        $reason_leave = $row["reason_leave"];
       
    }
        echo nl2br($reason_leave);
  
    
    function filterTable($query){
        $connect = mysqli_connect("localhost", "id18628321_a_tracker_final_v2", "UIP_Trackerv2_2022", "id18628321_a_tracker_final");
        $filter_Result = mysqli_query($connect, $query);
        
        return $filter_Result;
    }

?>