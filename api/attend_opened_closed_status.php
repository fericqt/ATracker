<?php 



    $query = "SELECT * FROM attendance_status ORDER BY id DESC LIMIT 1";



    $search_result= filterTable($query);

   

    

    while ($row = $search_result->fetch_assoc()) {

      $date = date('F j, Y', strtotime($row["date_opened"]));
      $time = date('g:i a', strtotime($row["date_opened"]));
       

        $attend = $row["attend_status"]. "|" . $row["event_title"];

    }

       

        echo $attend;

 

       

  

    

    function filterTable($query){

        $connect = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s", "u445178645_attendance");

        $filter_Result = mysqli_query($connect, $query);

        

        return $filter_Result;

    }



?>