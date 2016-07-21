<?php
date_default_timezone_set('America/Chicago');
require 'mysqli.php';
     if(isset($_POST['hiddenField'])){
        if(ctype_alnum($_POST['formPass']) && ctype_alnum($_POST['formUser'])){
            
        $username=$_POST['formUser'];
        $password=$_POST['formPass'];
            

        }   else{
            
            session_destroy();
            echo "Invalid username/password";
            header('Location: home.php');
            
            }
            
        $stmt = $mysqli->prepare("SELECT username, crypted_password FROM users WHERE username=?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        
        $stmt->bind_result($user_name,$pwd_hash);
        $stmt->fetch();
        $stmt->close();
        
            if (crypt($password,$pwd_hash)===$pwd_hash) {
                $_SESSION['username']=$user_name;
                $_SESSION['token'] = substr(md5(rand()), 0, 10);
                header('Location: home.php');
                   
            } else{
                session_destroy();
                echo "Invalid username/password";
                header('Location: home.php');
            }            
     }

     if(isset($_POST['logoutFlag'])){
        session_destroy();
        header('Location: home.php');
     }


if (!isset($_SESSION['username']) && !($_SERVER['REQUEST_URI']=='/~dmcdonnel/editArticle.php')){ ?>

<div>
    <form method='post'>
        <label>Username<input type = 'text' name = 'formUser'></label>
        <label>Password<input type = 'password' name = 'formPass'></label>
        <input name='hiddenField' type='hidden' value='login_flag'>
        <input type='submit' name='login' value='Login'/>
    </form>
</div>


<div>
    <form action='userregistration2.php' method='post'>
        <label>New User?<input type='submit' name='register' value='Register'/></label>
    </form>
</div>

<?php } else{
?>

<div>
    <form method='post'>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
        <input name='logoutFlag' type='hidden' value='logoutFlag'>
        <input type='submit' name='Logout' value='Logout'/>
    </form>
</div>
<?php
}
?>