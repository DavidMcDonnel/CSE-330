<?php
session_start();
require 'mysqli.php';

header("Content-Type: application/json");

    if(true){
        if(!ctype_alnum($_POST['day']) && !ctype_alnum($_POST['title']) && !ctype_alnum($_POST['start'])){
            echo json_encode(array(
		"success" => false,
                "message" => "Invalid input"
            ));
            exit;
        }else{
            //INSERT INTO `calendar`.`event` (`event_id`, `date`, `title`, `username`, `start`) VALUES (NULL, '2014-10-01', 'Test', 'dmcdonnel', '10:00:00');
	    //$now = new DateTime();
	    //$mins = $now->getOffset() / 60;
	    //$sgn = ($mins < 0 ? -1 : 1);
	    //$mins = abs($mins);
	    //$hrs = floor($mins / 60);
	    //$mins -= $hrs * 60;
	    //$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
	    //$stmtoffset= $mysqli->prepare("SET time_zone='$offset';");
            $stmt = $mysqli->prepare("INSERT INTO event (username,date,title,start) VALUES (?,?,?,?)");
            if(!$stmt) {
                echo json_encode(array(
		"success" => false,
                "message" => "Query preparation failed"
                ));
            }
	    //$stmtoffset->execute();
	    //$stmtoffset->close();
            
            $stmt->bind_param('ssss', $_SESSION['username'],$_POST['day'],$_POST['title'],$_POST['start']);
            $stmt->execute();
            $stmt->close();
            echo json_encode(array(
		"success" => true,
                "eventId" => $mysqli->insert_id
            ));
            exit;
        }
    }