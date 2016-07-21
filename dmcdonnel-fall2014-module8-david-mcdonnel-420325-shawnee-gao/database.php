
<?php
$mysqli = new mysqli('localhost', 'root', 'Kyuhyun1', 'eight');
if($mysqli -> connect_errno){
printf("Connection Failed: %s\n", $mysqli -> connect_error);
exit;
}
?>
