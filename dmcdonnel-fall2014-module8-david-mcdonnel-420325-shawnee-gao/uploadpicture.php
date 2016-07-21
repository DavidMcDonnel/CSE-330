<?php
require "database.php";
session_start();
if(isset($_SESSION['userid'])){
$userid = $_SESSION['userid'];
}
//var_dump($_FILES);
$filename = $_FILES["uploadedfile"]["name"];
$fileext = pathinfo($filename, PATHINFO_EXTENSION);
//echo $fileext;
$allowedExts = array("jpg", "jpeg", "gif", "png");
if(in_array($fileext, $allowedExts)){
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "/home/shawneegao/public_html/dmcdonnel-fall2014-module8-david-mcdonnel-420325-shawnee-gao/".basename($_FILES["uploadedfile"]["name"]))){
// echo "Stored in: " . "profilepics/" . $_FILES["file"]["name"];
$path = basename($_FILES["uploadedfile"]["name"]);
$stmt1 = $mysqli->prepare("update user set filename= ? where id =?");
if(!$stmt1) {
printf("Failed: %s\n", $mysqli->error);
exit;
}
$stmt1->bind_param('si', $path, $userid);
$stmt1->execute();
$stmt1->close();
header("Location: profile.php?username=".$_SESSION['username']);
}
else{
printf("failed");
//header("Location: upload_failure.html");
exit;
}
}
else{
echo "Invalid File: Image must be of type jpg, jpeg, gif, or png";
}
?>
