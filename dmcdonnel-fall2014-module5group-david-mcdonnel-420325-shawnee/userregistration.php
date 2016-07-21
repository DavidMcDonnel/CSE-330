<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'mysqli.php';
 
header("Content-Type: application/json");

$email=$_POST['email_reg'];
$username = $_POST['username_reg'];
$password =$_POST['password_reg'];
$password=crypt($password);

if($_POST['register_flag']==='true'){
    if(!(ctype_alnum($_POST['password_reg'])) && !(ctype_alnum($_POST['username_reg'])) && !filter_var($_POST['email_reg'], FILTER_VALIDATE_EMAIL)){
        echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username or Password"
            ));
            session_destroy();
            exit;
    } else{
        
        //$_SESSION['password']=$_POST['pass'];
        
        $stmt = $mysqli->prepare("insert into users(username, password,email) VALUES (?,?,?)");
        if(!$stmt){
            die("error on stmt");
        }
        $stmt->bind_param('sss', $username, $password,$email);
    
        $stmt->execute();
        $stmt->close();
    
        $_SESSION['username']=$_POST['username_reg'];
        setcookie('token',substr(md5(rand()), 0, 10), time() + (86400 * 30), "/");
    
        echo json_encode(array(
		"success" => true
            ));
        exit;

    }
} else{
    echo json_encode(array(
		"success" => false,
		"message" => "Request forged"
	));
        session_destroy();
	exit;
}


?>