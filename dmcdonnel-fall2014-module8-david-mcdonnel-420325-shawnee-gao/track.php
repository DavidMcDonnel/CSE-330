<?php
require 'database.php';
header("Content-Type: application/json");
if (isset($_POST['ordernumber'])) {
$ordernumber = $_POST['ordernumber'];
$stmt = $mysqli->prepare("select max(order_number) from orders");
if(!$stmt) {
exit;
}
$stmt -> execute();
$stmt -> bind_result($max);
$stmt -> fetch();
$stmt -> close();
if ($ordernumber <= $max) {
$stmt = $mysqli->prepare("select status from orders where order_number = ?");
if(!$stmt) {
exit;
}
$stmt->bind_param('i', $ordernumber);
$stmt -> execute();
$stmt -> bind_result($status);
$stmt -> fetch();
$stmt -> close();
$orderstatus = array(
"status" => $status
);
if ($status == null) {
echo json_encode(array (
"status" => "error"
)
);
}
else {
echo json_encode($orderstatus);
}
}
else {
echo json_encode(array (
"status" => "error"
)
);
}
}
else {
echo json_encode(array (
"status" => "error"
)
);
}
?>
