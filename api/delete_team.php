<?php

	include("db/dbconnection.php");	

	$delete_team = $_POST['delete_team_id'];

	$sql = "SELECT * FROM team_members WHERE team_name_id = '$delete_team'";
	$result = $conn->query($sql);

		if(mysqli_num_rows($result) > 0)
		{
			echo '0';
		}

		else
		{
			$sql1 = "SELECT * FROM team WHERE team_id = '$delete_team'";
			$result1 = $conn->query($sql1);
			
			$response = array();
				
			if ($result1->num_rows > 0) 
				{
					if($row = $result1->fetch_assoc()) 
					{	
						if (($row["leader_id"] == '0') && ($row["co_leader_id"] == '0'))
						{
							$sql2 = "DELETE FROM team WHERE team_id = '$delete_team'";

								if ($conn->query($sql2) === TRUE)
								{
									echo "2";
								}
			
								else 
								{
							  		echo "1";
								}
						}

						else
						{
							echo "1";
						}
					
				  	}
				} 

			else 
			{
				echo "0";
			}
				
		}

    $conn->close();	
?>