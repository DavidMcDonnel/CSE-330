<!DOCTYPE html>

<html lang="en">
     <head>
         <meta charset="utf-8"/>
         <title>News Home</title>
         <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
     </head>
     <body class="home">
          
<?php
session_start();
require 'mysqli.php';

if(isset($_POST['hiddenField'])){
     if(ctype_alnum($_POST['formPass']) && ctype_alnum($_POST['formUser'])){
          $username=$_POST['formUser'];
          $_SESSION['username']=$username;
          $password=$_POST['formPass'];
     }
     else{
          session_destroy();
          $_SESSION['loginfail']=1;
          //header('home.php');            
     }
        
     $stmt = $mysqli->prepare("SELECT id, crypted_password FROM users WHERE username=?");
        
     $stmt->bind_param('s', $username);
     $stmt->execute();
        
     $stmt->bind_result($user_id, $pwd_hash);
     $stmt->fetch();
     $stmt->close();
        
     if (!crypt($_POST['formPass'],$pwd_hash)===$pwd_hash) {
          session_destroy();
          echo "Invalid username/password";
          //header('Location: home.php');
     }
     else{
          $_SESSION['id']=$user_id;
          echo 'Welcome!';
          
          $upload="<form action='news.php' method='post'> \n";
          $upload.="     <input type='submit' name='Upload' value='upload'/>";
          $upload.="</form>";
          echo $upload;
          //header('Location: home.php');
     }
}

$register="<form action='userregistration.php' method='post'> \n";
$register.="     New User? <input type='submit' name='register' value='Register'> <br> \n";
$register.="</form> <br>";
     
if(isset($_POST['logoutFlag'])){
     session_destroy();
     header("Location: home2.php");
}
     
if(isset($_SESSION['uploaded'])){
     echo 'Your page has been uploaded.';
     $_SESSION['uploaded']=null;
          $upload="<form action='news.php' method='post'> \n";
          $upload.="     <input type='submit' name='Upload' value='Upload another'/>";
          $upload.="</form>";
          echo $upload;
}

if (!isset($_SESSION['username'])){
     $login="";
     $login .= "<form action='home2.php' method='post'> </br>";
     $login .= "     <label>Username: <input type = 'text' name = 'formUser'></label> </br>";
     $login .= "     <label>Password: <input type = 'password' name = 'formPass'></label> </br>";
     $login .= "     <input name='hiddenField' type='hidden' value='login_flag'>";
     $login .= "     <input type='submit' name='login' value='Login'/> </br>";  
     $login .= "</form>";

     echo $login;
}

echo "<h3> PHP List All Session Variables</h3>";
print_r($_SESSION);

?>

<form action='home2.php' method='post'>
     <input type='hidden' name='logoutFlag' value='logoutFlag'>
     <input type='submit' name='Logout' value='Log out'>
</form>

</body>
</html>