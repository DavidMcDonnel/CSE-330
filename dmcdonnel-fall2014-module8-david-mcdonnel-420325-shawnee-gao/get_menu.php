<?php
require "database.php";
if(isset($_POST['id'])){
$stmt = $mysqli->prepare("select name, price from animal where id = ?");
$stmt->bind_param('i', $_POST['id']);
$stmt->execute();
$stmt->bind_result($name, $price);
$stmt->fetch();
$stmt->close();
echo json_encode(
array(
"success"=>true,
"name"=>$name,
"price"=>$price
)
);
}
?>
