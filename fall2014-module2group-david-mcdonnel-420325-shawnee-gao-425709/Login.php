<?php
session_start();
ini_set();

if($_SESSION['badLogin']==true){
    echo "invalid username";
    $_SESSION=array();
    session_destroy();
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
</head>

<body class="login">
    <div>
        <form action="http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/login2.php" method="post">
                <label>Username<input type = "text" name = "formUser"></label>
                <input type="submit" name="submit"/>
                <?php echo "<h3> PHP List All Session Variables</h3>";
                    foreach ($_SESSION as $key=>$val){
                         echo $key." ".$val."<br/>";
                     }
                     foreach ($username as $key=>$val){
                        echo $key." ".$val."<br>";
                     }
                     echo $_POST['formuser'];
                     ?>
         </form>
    </div>



</body>
</html>
