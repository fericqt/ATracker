<?php 

    $id = (int)$_GET['id']; 
   
    $query = "SELECT *
    FROM webinar WHERE webinar_id = '".$id."'";

    $search_result= filterTable($query);
   
    
    while ($row = $search_result->fetch_assoc()) {
      
       
        $intern = $row["title_name"]. "|" . $row["webinar_desc"] . "|" . $row["meeting_link"] . "|" . $row["speaker"] . "|" . $row["meeting_date"] . "|" . $row["meeting_time"]. "|" . $row["webinar_id"]. "|" . $row["registration_fee"];
        
       
    }
        echo $intern;
  
    
    function filterTable($query){
        $connect = mysqli_connect("localhost", "root", "", "a_tracker");
        $filter_Result = mysqli_query($connect, $query);
        
        return $filter_Result;
    }

?>