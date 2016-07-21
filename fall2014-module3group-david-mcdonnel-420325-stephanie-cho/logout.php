<?php
session_start();
session_destroy();
header('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
?>