<?php
session_start();
date_default_timezone_set('America/Chicago');
require 'mysqli.php';

header("Content-Type: application/json");
    if(!isset($_SESSION['username'])){
            echo json_encode(array(
		"success" => false,
                "message" => "Not logged in"
            ));
            exit;
        }else{
            $stmt = $mysqli->prepare("SELECT event_id,UNIX_TIMESTAMP(cast(date as datetime)+cast(start as datetime)) as dateandtime,title FROM event where username=? ORDER BY date DESC ");
            $stmt->bind_param('s',$_SESSION['username']);
            if(!$stmt) {
                echo json_encode(array(
		"success" => false,
                "message" => "Query preparation failed"
                ));
            }
            if(!$stmt->execute()){
                echo json_encode(array(
		"success" => false,
                "message" => "Query execution failed"
                ));
            } else{
            $result=$stmt->get_result();
            while($row = $result->fetch_assoc()){
                $eventList[] = array(
                    'id' => (int) $row['event_id'],
                    'title' => $row['title'],
                    'start' => $row['dateandtime']*1000
                );
            }
            }
            $stmt->close();
            echo json_encode($eventList);
        }
?>