<?php

if(!isset($_POST["ammo"]) || !isset($_POST["soldiers"]) || !isset($_POST["duration"]) || !isset($_POST["critique"])){
  trigger_error("You did not submit the form correctly");
} else{
    $ammo=      (int) $_POST["ammo"];
    $soldiers=  (int) $_POST["soldiers"];
    $duration=  (int) $_POST["duration"];
    $critique=  (string) $_POST["critique"];
    
    $mysqli = new mysqli('localhost', 'php', 'module3', 'battlefield');
 
    if($mysqli->connect_errno) {
            printf("Connection Failed: %s\n", $mysqli->connect_error);
            exit;
    }
    
    $stmt = $mysqli->prepare("insert into reports (ammo, soldiers, duration, critique) VALUES (?,?,?,?)");
    
    if (!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
    }
    
    $stmt->bind_param('iiis', $ammo, $soldiers, $duration, $critique);
    if (!$stmt->execute()){
        printf("Statement Failed: %s\n", $stmt->error);
    } else {
        header("Location: battlefield-submit.html");
    }
    $stmt->close();
    
}
?>