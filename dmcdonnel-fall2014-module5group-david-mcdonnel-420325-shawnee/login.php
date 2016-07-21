<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'mysqli.php';
 
header("Content-Type: application/json");
$username = $_POST['username_log']; 
$password = $_POST['password_log'];

if($_POST['login_flag']==='true'){
	
        if(!ctype_alnum($_POST['username_log']) && !ctype_alnum($_POST['password_log'])){
            echo json_encode(array(
		"success" => false,
                "message" => "Username or password invalid"
            ));
            session_destroy();
            exit;
        } else{
            //$_SESSION['token'] = substr(md5(rand()), 0, 10);
        
        $stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username=?");
        if(!$stmt) {
            echo json_encode(array(
		"success" => false,
                "message" => "Error preparing query"
            ));
            session_destroy();
            exit;
        }
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        
        $stmt->bind_result($user_name,$pwd_hash);
        $stmt->fetch();
        $stmt->close();
        
            if(crypt($password,$pwd_hash)===$pwd_hash){
                $_SESSION['username']=$user_name;
                echo json_encode(array(
		"success" => true,
                ));
                setcookie('token',substr(md5(rand()), 0, 10), time() + (86400 * 30), "/");
                exit;
               
                   
            } else{
                
                echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
                ));
                session_destroy();
                exit;
            }
        }
 
	
}elseif(isset($_POST['logout_flag'])){
	echo json_encode(array(
		"success" => true
	));
        session_destroy();
	exit;
} else{
	echo json_encode(array(
		"success" => false,
		"message" => "Request forged"
	));
        session_destroy();
	exit;
}
?>