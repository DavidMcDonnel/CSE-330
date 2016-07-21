<?php
require 'database.php';
if(isset($_POST['fb'])){
if($_POST['fb'] == 'true'){
$userid = $_POST['userid'];
$username = $_POST['username'];
ini_set("session.cookie_httponly", 1);
session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];
if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
die("Session hijack detected");
}else{
$_SESSION['useragent'] = $current_ua;
}
$_SESSION['userid'] = $userid;
$_SESSION['username'] = $username;
$_SESSION['fb'] = true;
echo json_encode(
array(
"success"=>true,
"message"=>$_POST['fb'],
"userid"=>$userid,
"username"=>$_SESSION['username'],
"fb"=>$_SESSION['fb']
)
);
exit;
}
else{
if(isset($_POST['username'])){
$username = $_POST['username'];
$password = $_POST['pass'];
$stmt = $mysqli->prepare("select count(username), id, username, password from user where username=?");
if(!$stmt){
echo json_encode(
array(
"success"=>false,
"message"=>$mysqli->error
)
);
exit;
}
//$encrypted = $password;
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($count, $id, $user, $hashpass);
$stmt->fetch();
$stmt->close();
$encrypted = crypt($password, $hashpass);
if ($count == 1 && $user==$username && $encrypted==$hashpass) {
ini_set("session.cookie_httponly", 1);
session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];
if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
die("Session hijack detected");
}else{
$_SESSION['useragent'] = $current_ua;
}
$_SESSION['userid'] = $id;
$_SESSION['username'] = $username;
$_SESSION['fb'] = false;
//$_SESSION['isadmin'] = $isadmin;
$_SESSION['checkuser'] = true;
$_SESSION['token'] = substr(md5(rand()), 0, 10);
echo json_encode(
array(
"success"=>true,
"username"=>$username
)
);
exit;
}
else {
echo json_encode(
array(
"success"=>false,
"message"=>"wrong password or username"
)
);
}
}
}
}
else{
echo json_encode(
array(
"success"=>false
)
);
exit;
}
?>
