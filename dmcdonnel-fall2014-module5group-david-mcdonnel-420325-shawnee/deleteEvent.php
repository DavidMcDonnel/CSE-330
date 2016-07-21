<?php
session_start();
require 'mysqli.php';

header("Content-Type: application/json");

    if($_POST['deleteEvent_flag']==='true' && $_POST['token']===$_SESSION['token']){
            $stmt = $mysqli->prepare("DELETE FROM event WHERE username=? and event_id=?");
            if(!$stmt) {
                echo json_encode(array(
		"success" => false,
                "message" => "Query preparation failed"
                ));
            }
            
            $stmt->bind_param('ss', $_SESSION['username'],$_POST['event_id']);
            $stmt->execute();
            $stmt->close();
            echo json_encode(array(
		"success" => true
            ));
            exit;
    }