<?php
session_start();
require 'mysqli.php';

header("Content-Type: application/json");

    if($_POST['editEvent_flag']==='true' && $_POST['token']===$_SESSION['token']){
        if(!ctype_alnum($_POST['day']) && !ctype_alnum($_POST['title']) && !ctype_alnum($_POST['start'])){
            echo json_encode(array(
		"success" => false,
                "message" => "Invalid input"
            ));
            exit;
        }else{
            $stmt = $mysqli->prepare("UPDATE event set date=?,title=?,start=? where event_id=?");
            if(!$stmt) {
                echo json_encode(array(
		"success" => false,
                "message" => "Query preparation failed"
                ));
            }
            
            $stmt->bind_param('ssss',$_POST['day'],$_POST['title'],$_POST['start'],$_POST['id']);
            $stmt->execute();
            $stmt->close();
            echo json_encode(array(
		"success" => true
            ));
            exit;
        }
    }