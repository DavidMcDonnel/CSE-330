<?php
session_start();
require 'mysqli.php';

if(isset($_SESSION['token']) && $_SESSION['token']!==$_POST['token']){
   die("Request forgery detected");
}else{
    if(!(isset($_SESSION['username']))){
        header("Location: home.php");
    } else{
    if(isset($_POST['hiddenField'])){
        $stmt = $mysqli->prepare("insert into articles (username, description, body, url, upload_date) VALUES (?,?,?,?,now())");

        if (!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        $stmt->bind_param('ssss', $_SESSION['username'], $_POST['description'], $_POST['story'], $_POST['url']);
        $stmt->execute();
        $stmt->close();
        $_SESSION['uploaded']=1;
        header("Location: home.php");
    } else{
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Article</title>
    <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
</head>
<body>
<form method='post' action='<?php $_SERVER['REQUEST_URI'];?>'>
    Description (required): <textarea name="description" required></textarea><br>
    Textbox: <textarea name="story" ></textarea><br>
    URL: <textarea name="url" ></textarea><br>
    <input type="hidden" name="hiddenField" value="hiddenField">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
    <input type="submit" value="Upload article">
  </form>
</body>
</html>
<?php }
    }
}
?>