<?php
  
    if(team($user_id) == 77)
    {
        die("0");
    }

    function team ($id)
    {
            include('db/dbconnection.php');

            $user_id = $id;

            $sql1 = "SELECT * FROM team WHERE team.leader_id = '$user_id'";
 
	        $result1 = $conn->query($sql1);
     
            if ($result1->num_rows > 0) {

	            if($row1 = $result1->fetch_assoc()) {
                     $team_name = $row1["team_id"];
	            }
	        }else{

                $sql1 = "SELECT * FROM team WHERE team.co_leader_id = '$user_id'";
    
	            $result1 = $conn->query($sql1);
     
                if ($result1->num_rows > 0) {

	                if($row1 = $result1->fetch_assoc()) {
                        $team_name = $row1["team_id"];
	                }
	            }
            }
            $sql1 = "SELECT * FROM team_members, user_acc WHERE team_members.user_acc_id=user_acc.user_acc_id AND team_members.user_acc_id='$user_id'";
    
	        $result1 = $conn->query($sql1);
     
            if ($result1->num_rows > 0) {

	            if($row1 = $result1->fetch_assoc()) {

		            $team_id = $row1["team_name_id"];

                    $sql2 = "SELECT * FROM team WHERE team_id ='$team_id'";
    
	                $result2 = $conn->query($sql2);
     
                    if ($result2->num_rows > 0) {

	                    if($row2 = $result2->fetch_assoc()) {
		                     $team_name = $row2["team_id"];
	                    }
	                }
	            }
	        }  
            return $team_name; 
    
            $conn->close();	   
        }  

?>
