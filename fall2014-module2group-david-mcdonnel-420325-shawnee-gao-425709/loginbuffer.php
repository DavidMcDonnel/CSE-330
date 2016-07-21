<?php
session_start();

$_SESSION['username']=$_POST['username'];
$myfile= fopen("./users.txt","r");
$USERS= array();

    while(!feof($myfile)){
        $line = fgets($myfile);
        $USERS[]=$line;
    }
    if(in_array($_SESSION['username'],$USERS)){
        header("Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php");
    }else{
        $_SESSION['badlogin']==true;
        header("Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/Login.php");
    }
?>