<?php
// Content of database.php
 
$mysqli = new mysqli('localhost', 'php', 'module3', 'calendar');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>