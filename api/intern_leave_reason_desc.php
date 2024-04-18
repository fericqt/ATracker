<?php 



    $id = $_GET['id']; 

   

    $query = "SELECT *

    FROM intern_leave

    WHERE leave_id = '".$id."'";



    $search_result= filterTable($query);

	

    

    while ($row = $search_result->fetch_assoc()) {

		

        $reason_leave = $row["reason_leave"];

       

    }

        echo nl2br($reason_leave);

  

    

    function filterTable($query){

        $connect = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s", "u445178645_attendance");

        $filter_Result = mysqli_query($connect, $query);

        

        return $filter_Result;

    }



?>