<?php 



    $user_acc_id = $_GET['id']; 

   

    $query = "SELECT *

    FROM intern_report

    WHERE report_id = '".$user_acc_id."'";



    $search_result= filterTable($query);

	

    

    while ($row = $search_result->fetch_assoc()) {

		

        $report_details = $row["report_details"];

       

    }

        echo $report_details;

  

    

    function filterTable($query){

        $connect = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s", "u445178645_attendance");

        $filter_Result = mysqli_query($connect, $query);

        

        return $filter_Result;

    }



?>