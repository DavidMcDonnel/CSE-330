<?php

require "database.php";
session_start();
$new_item_name = $_POST['name'];
$new_item_price = $_POST['price'];
$item_id = $_POST['id'];
if($_SESSION['username'] == "admin"){
$stmt = $mysqli->prepare("update menu set name=?, price=? where id=?");
if(!$stmt){
echo json_encode(
array(
"success"=>false,
"message"=>$mysqli->error
)
);
}
$stmt->bind_param('sdi', $new_item_name, $new_item_price, $item_id);
$stmt->execute();
$stmt->close();
echo json_encode(
array(
"success"=>true
)
);
}
?>
