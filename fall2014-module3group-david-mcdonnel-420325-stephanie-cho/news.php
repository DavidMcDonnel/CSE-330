<?php
session_start();
require 'mysqli.php';

    if(!(isset($_SESSION['username']))){
        echo 'You must log in to add a new article.';
        exit;
    }

    if(isset($_POST['hiddenField'])){
        $stmt = $mysqli->prepare("insert into articles(username, description, body, upload_date) VALUES (?,?,?,now())");

        if (!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        print_r($_POST);
        $stmt->bind_param('sss', $_SESSION['username'], $_POST['description'], $_POST['story']);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['uploaded']=1;
        header("Location: home2.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add?</title>
</head>
<body>
<form method='post' action=''>
    Description (required): <textarea name="description" id='description'></textarea><br>
    Textbox: <textarea name="story" id="story"></textarea><br>
    <input type="hidden" name="hiddenField">
    <input type="submit" value="Upload article">
  </form>
</body>
</html>