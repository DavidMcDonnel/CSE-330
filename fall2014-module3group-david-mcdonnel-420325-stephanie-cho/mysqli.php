<?php
// Content of database.php
 
$mysqli = new mysqli('localhost', 'php', 'module3', 'news');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>