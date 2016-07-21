<?php
session_start();


    if(isset($_POST['hiddenField'])){
        printf("flag set");
            if(ctype_alnum($_POST['username']) && ctype_alnum($_POST['password']) && filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL)){
                
                require 'mysqli.php';
                
                $username=$_POST['username'];
                $password=$_POST['password'];
                $email=$_POST['email_address'];
                $_SESSION['username']=$username;
            
        
                $password=crypt($password);
                
                $stmt = $mysqli->prepare("INSERT into users (username,crypted_password,email_address) VALUES (?,?,?)");
                if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                }
                
                $stmt->bind_param('sss', $username, $password, $email);
                $stmt->execute();
                $stmt->close();
                
                printf("Executed sql: great, check table");
                header('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
                
            } else{
                
                printf("Invalid input: bad");
                header('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
                
            }
    } else {
?>

<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8"/>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
    </head>
    
    <body class="registration">
        <form action="home.php" method='post'>
            
            <label>Username<input type="text" name="username" required></label>
            
                <br>
                    
            <label>Password<input type="password" name="password" required></label>
            
                <br>
                    
            <label>Email<input type="text" name="email_address" required></label>
            
                <br>
                    
            <input name="hiddenField" type="hidden" value="register_flag">
            <input type="submit" name="submit"/>
        </form>
    <?php } ?>
    </body>
</html>
