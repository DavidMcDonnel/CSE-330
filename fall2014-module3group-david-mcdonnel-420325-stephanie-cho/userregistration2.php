<?php
session_start();

require 'mysqli.php';


if(isset($_POST['register_mysql'])){
    if(!(ctype_alnum($_POST['pass'])) && !(ctype_alnum($_POST['usr'])) && !filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL)){
        echo "Invalid username/password. <br> Please make sure passwords and usernames are only alphanumeric.";
    } else{
        $_SESSION['username']=$_POST['usr'];
        //$_SESSION['password']=$_POST['pass'];
        $email=$_POST['email_address'];
        $username = $_SESSION['username'];
        $password =$_POST['pass'];
        $password=crypt($password);
        
    
    $stmt = $mysqli->prepare("insert into users(username, crypted_password,email_address) VALUES (?,?,?)");
    
    if (!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('sss', $username, $password,$email);


    $stmt->execute();
    $stmt->close();

    header("Location: home.php");
    exit;

    }
}


?>
<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8"/>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
    </head>
    <body class="registration">
        <form method='post' >
            <br>
            Please write the username, password, and email you would like to register:
            <br>
                 Username: <input type='text' name='usr' placeholder='username' required>
                 <br>
                 Password: <input type='password' name='pass' placeholder='password' required>
                 <br>
                 Email: <input type='text' name='email_address' placeholder='email' required>
                 <br>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                 <input type='submit' name='register_mysql' value='Register!'>
                 <br>
        </form>
    </body>
</html>