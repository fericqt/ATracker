<?php
	include("db/dbconnection.php");

    //$sql = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id";

    $sql = "SELECT * FROM team";

    //$sql_with_Leader_ID = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id";
    //$sql_with_co_Leader_ID = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      $response['data'] = array();
      // output data of each row

      while($row = $result->fetch_array()) {

        if($row["leader_id"]==0) //no leader found
        {
            if ($row["co_leader_id"]==0)//no leader and co leader found
            {
                $view_team = array();
                $view_team["ID"] = $row["team_id"];
                $view_team["Team Name"] = $row["team_name"];
                $view_team["Team Leader"] = "<strong>NO LEADER</strong?";
                $view_team["Lead ID"] = 0;
                $view_team["Co Leader"] = "<strong>NO CO LEADER</strong?";
                $view_team["Co-Lead ID"] = 0;

                array_push($response['data'], $view_team);
            }
            else //no leader but co leader found
            {
                $view_team = array();

                $view_team["ID"] = $row["team_id"];
                $view_team["Team Name"] = $row["team_name"];
                $view_team["Team Leader"] = "<strong>NO LEADER</strong?";
                $view_team["Lead ID"] = 0;

                $sql_with_co_Leader_ID = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id AND team.team_id="  . $row["team_id"];

                $result_co_leader = $conn->query($sql_with_co_Leader_ID);

                while($row_co_leader = $result_co_leader->fetch_array()) {
                    $view_team["Co Leader"] = $row_co_leader["firstname"]." ".$row_co_leader["middle_name"]." ".$row_co_leader["lastname"];
                    $view_team["Co-Lead ID"] = $row_co_leader["co_leader_id"];
                }

                array_push($response['data'], $view_team);
            }

        }

        else if($row["co_leader_id"]==0) //Leader found but no co leader
        {
            $view_team = array();
            $view_team["ID"] = $row["team_id"];
            $view_team["Team Name"] = $row["team_name"];
            $view_team["Co Leader"] = "<strong>NO CO LEADER</strong?";
            $view_team["Co-Lead ID"] = 0;

            $sql_with_Leader_ID = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.team_id=" . $row["team_id"];
            $result_leader = $conn->query($sql_with_Leader_ID);

            while($row_leader = $result_leader->fetch_array()) {
                $view_team["Team Leader"] = $row_leader["firstname"]." ".$row_leader["middle_name"]." ".$row_leader["lastname"];
                $view_team["Lead ID"] = $row_leader["user_acc_id"];
            }

            array_push($response['data'], $view_team);
        }
        else
        {
            $view_team = array();
            $view_team["ID"] = $row["team_id"];
            $view_team["Team Name"] = $row["team_name"];

            $sql_with_Leader_ID = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.team_id=" . $row["team_id"];
            $result_leader = $conn->query($sql_with_Leader_ID);

            while($row_leader = $result_leader->fetch_array()) {
                $view_team["Team Leader"] = $row_leader["firstname"]." ".$row_leader["middle_name"]." ".$row_leader["lastname"];
                $view_team["Lead ID"] = $row_leader["user_acc_id"];
            }

            $sql_with_co_Leader_ID = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id AND team.team_id=" . $row["team_id"];
            $result_co_leader = $conn->query($sql_with_co_Leader_ID);

            while($row_co_leader = $result_co_leader->fetch_array()) {

                $view_team["Co Leader"] = $row_co_leader["firstname"]." ".$row_co_leader["middle_name"]." ".$row_co_leader["lastname"];
                $view_team["Co-Lead ID"] = $row_co_leader["co_leader_id"];
            }

            array_push($response['data'], $view_team);
        }
    }
      echo json_encode($response);  



    } else {


      echo json_encode(array('data'=>''));


    }








    $conn->close();


?>