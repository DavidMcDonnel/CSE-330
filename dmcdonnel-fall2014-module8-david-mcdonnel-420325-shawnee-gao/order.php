<?php
require 'database.php';
session_start();
header("Content-Type: application/json");
$stmt1 = $mysqli->prepare("DELETE FROM animal WHERE animal id = ?");
if(!$stmt1){
echo json_encode(
array(
"success" => false,
"message" => $mysqli->error
)
);
exit;
}
$stmt1->bind_param('i', $_POST['animal_id']);
$stmt1->execute();
$stmt1->close();
echo json_encode(
array(
"success" => true,
"message" => "Your order has been placed!"
)
);
