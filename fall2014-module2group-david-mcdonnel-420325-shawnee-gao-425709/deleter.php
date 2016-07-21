<?php
session_start();

$basepath = __DIR__;
$file = basename($_SERVER['REQUEST_URI']);
$path = $basepath . '/' . $file;
$exists = file_exists($path);

$success = unlink("./filesite/".$_SESSION['username']. "/". $_POST['delete']);
if ($success) {
    header('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
} else {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
}
?>