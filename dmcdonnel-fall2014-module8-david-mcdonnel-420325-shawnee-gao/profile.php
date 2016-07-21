<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css"
type="text/css" rel="Stylesheet" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<title>
<?php
session_start();
if(isset($_GET['username'])){
echo $_GET['username'];
}
else{
if(isset($_SESSION['username'])){
echo $_SESSION['username'];
}
else{
echo "Profile";
}
}
?>
</title>
</head>
<body>
<b><a href="home.phtml" class="left">Home</a><b>
<div id="content">
<?php
require "database.php";
//require "database2.php";
$stmt = $mysqli->prepare("select id from user where username = ?");
if(!$stmt){
echo $mysqli->error;
}
$stmt->bind_param('s', $_GET['username']);
$stmt->execute();
$stmt->bind_result($userid);
$stmt->fetch();
$stmt->close();
if(isset($_SESSION['userid'])){
if($_SESSION['userid'] == $userid){
echo '<div id="edit_stuff_btn" class="right">
<form id="uploadprofilepic" enctype="multipart/form-data" action="uploadpicture.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
<label for="uploadfile_input">Change profile picture:<br>
</label><input name="uploadedfile" type="file" id="uploadfile_input" />
<br>
<input type="submit" value="Upload File" />
</form>
</div>';
}
}
?>
<div id="intro">
<?php
/*if(!isset($_GET['username'])&&isset($_SESSION['userid'])){
$stmt = $mysqli->prepare("select username, filename from user where id=?");
$stmt->bind_param('i', $_SESSION['userid']);
$stmt->execute();
$stmt->bind_result($username, $path);
$stmt->fetch();
$stmt->close();

echo "$username";
echo "$path";

echo "<img height = '300' width = '200' src='".$path."'/><br>";

echo "<br><b>Get an account dummy</b>";
}
else*/
if(isset($_GET['username'])&&isset($_SESSION['userid'])){
$stmt = $mysqli->prepare("select username, filename from user where id = ?");
if(!$stmt){
echo $mysqli->error;
}
$stmt->bind_param('s', $_SESSION['userid']);
$stmt->execute();
$stmt->bind_result($username, $path);
$stmt->fetch();
$stmt->close();
if($userid == $_SESSION['userid']){
echo "<img height = '300' width = '300' src='".$path."'/><br>";
echo "<b>".$username."</b><br>you are<br><b>a new pet owner!</b>";
}
else{
echo "<img src='".$path."'/><br>";
echo "<b>".$_GET['username']."</b><br>is<br><b>Fresh Off the Boat</b>";
}
}
else{
echo "Login to view Fresh Off the Boat profiles!";
}
?>
</div>

<div id = "orderstatus" class = "right">
<?php
if(isset($_GET['username'])&&isset($_SESSION['userid'])){
echo " <form action = 'twilio.php' method = 'POST'>
	<input type = 'submit' value = 'stuff'></input></form>";
}
?>
</div>
</body>
</html>

