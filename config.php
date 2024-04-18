<?php
    //server name, username, password, database
    $con = mysqli_connect("localhost", "u445178645_admintime", "M46[uMf:KT&s", "u445178645_attendance");



    if(mysqli_connect_errno()){

        echo "Failed to connect:" . mysqli_connect_errno();

    }

?>