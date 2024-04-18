<?php 



    $id = (int)$_GET['id']; 

   

    $query = "SELECT *

    FROM weekly_report WHERE weekly_report_id = '".$id."'";



    $search_result= filterTable($query);

   

    

    while ($row = $search_result->fetch_assoc()) {

      

       

        $intern = $row["weekly_report_id"]. "|" . $row["weekly_no"]. "|" . $row["gdrive_link"];

        

       

    }

       

        echo $intern;

 

       

  

    

    function filterTable($query){

        $connect = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s^", "u445178645_attendance");

        $filter_Result = mysqli_query($connect, $query);

        

        return $filter_Result;

    }



?>