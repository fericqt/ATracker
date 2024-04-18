<head>
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>

<?php

include("db/dbconnection.php");

    
    $emailTo = $_POST["email"];

    $sql  = "select * from intern_info where username = '$emailTo'";
    
    $result = $conn->query($sql); 
    
    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_array()) {
        
        if($row["intern_status"] == "Unassigned"){ 

            echo "<script>
            setTimeout(function() {
            swal({
                type: 'warning',
                title: 'Pending for Approval',
                text: 'Please wait patiently while the Desktop support are checking your documents. Don`t forget to check your spam folder. Thank you and Have a nice day!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";
        }else if($row["intern_status"] == "Ongoing"){ 

            echo "<script>
            setTimeout(function() {
            swal({
                type: 'success',
                title: 'Approved Intern',
                text: 'Your account status is Ongoing Intern. Thank you and Have a nice day!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";
        }else if($row["intern_status"] == "Offboarding"){ 

            echo "<script>
            setTimeout(function() {
            swal({
                type: 'info',
                title: 'Offboarding Intern',
                text: 'Your account status is Offboarding Intern. Thank you and Have a nice day!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";
        }else if($row["intern_status"] == "Completed"){ 

            echo "<script>
            setTimeout(function() {
            swal({
                type: 'success',
                title: 'Completed Intern',
                text: 'Your account status is Completed Intern. Thank you and Have a nice day!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";
        }else if($row["intern_status"] == "Terminated"){ 

            echo "<script>
            setTimeout(function() {
            swal({
                type: 'error',
                title: 'Account Terminated',
                text: 'Your account status is Terminated Intern which means you have no longer the access to login on your account. Thank you and Have a nice day!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";
        }
    }
}else{
            echo "<script>
            setTimeout(function() {
            swal({
                type: 'error',
                title: 'Email does not exist!',
                text: 'The system can`t find this email in the database. Please try signing up again. Thank you!'
            }, function() {
                window.location = '../index.html';
            });
            }, 10);
            </script>";    
}
    

  
?>