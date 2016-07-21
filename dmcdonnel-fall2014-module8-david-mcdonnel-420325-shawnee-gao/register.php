<?php
require 'database.php';
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['confirm'])){
$username = $_POST['username'];
$password = $_POST['password'];
$confirmpass = $_POST['confirm'];
$phone = $_POST['phone'];
if($username == "admin"){
echo json_encode(
array(
"success"=>false,
"message"=>"username not allowed"
)
);
exit;
}
$stmt1 = $mysqli->prepare("select count(*) from user where username like '$username'");
if(!$stmt1) {
echo json_encode(
array(
"success"=>false,
"message"=>"an error occured, please try again."
)
);
exit;
}
$stmt1->execute();
$stmt1->bind_result($number);
$stmt1->fetch();
$stmt1->close();
if ($number > 0) {
echo json_encode(
array(
"success"=>false,
"message"=>"that username is already taken."
)
);
exit;
}
else {
if(strcmp($password, $confirmpass) == 0) {
$stmt = $mysqli->prepare("insert into user(username, password, phone) values(?, ?,?)");
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$encrypted = crypt($password);
$stmt->bind_param('sss', $username, $encrypted, $phone);
$stmt->execute();
$stmt->close();
echo json_encode(
array(
"success"=>true
)
);
exit;
}
else{
echo json_encode(
array(
"success"=>false,
"message"=>"please confirm your password"
)
);
exit;
}
}
}
?>
