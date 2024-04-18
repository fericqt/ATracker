<?php 

    $id = (int)$_GET['id']; 
   
    $query = "SELECT *
    FROM team WHERE leader_id = '".$id."'";

    $search_result= filterTable($query);
   
    
    while ($row = $search_result->fetch_assoc()) {
      
       
        $intern = $row["team_id"];
        
       
    }
    if(!empty($intern)){
       
        echo $intern;
    }else{
        echo "0";
    }
       
  
    
    function filterTable($query){
        $connect = mysqli_connect("localhost", "id18628321_a_tracker_final_v2", "UIP_Trackerv2_2022", "id18628321_a_tracker_final");
        $filter_Result = mysqli_query($connect, $query);
        
        return $filter_Result;
    }

?>