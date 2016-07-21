<?
require "database.php";
session_start();
if(isset($_SESSION['userid'])){
$currentuserid = $_SESSION['userid'];
}
$stmt = $mysqli->prepare("select profilepic from restaurantUsers where userid = ?");
if(!$stmt){
printf("Failed: %s\n", $mysqli->error);
exit;
}
$stmt->bind_param('i', $currentuserid);
$stmt->execute();
$stmt->bind_result($profilepic);
$stmt->fetch();
$stmt->close();
echo json_encode($profilepic);
?>
