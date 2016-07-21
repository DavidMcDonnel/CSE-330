<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: home.php");
} else{
?>
<!DOCTYPE html>

<html lang="en">
     <head>
         <meta charset="utf-8"/>
         <title>Edit Article</title>
         <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
     </head>
     <body class="edit">
        <?php
        require 'mysqli.php';
        
        $logout="";
        $logout .="<form method='post'> \n";
        $logout .="    <input name='logoutFlag' type='hidden' value='logoutFlag'> \n";
        $logout .="    <input type='submit' name='Logout' value='Logout'/> \n";
        $logout .= "</form> \n";
        //echo $logout;
            
        if(isset($_SESSION['token']) &&  $_SESSION['token']!==$_POST['token']){
           die("Request forgery detected");
        }else{
            
            if(isset($_POST['edit_flag'])){
                
                $stmt = $mysqli->prepare("UPDATE articles set description=?,body=?,url=?,upload_date=now() WHERE id=?");
                
                if (!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->bind_param('ssss', $_POST['description'],$_POST['body'],$_POST['url'],$_POST['id_Value']);
                $stmt->execute();
                $stmt->close();
                header("Location: home.php");
            } else if(isset($_POST['delete_flag'])){
                
                $stmt_articles=$mysqli->prepare("DELETE FROM comments where article_id=?");
                
                $stmt = $mysqli->prepare("DELETE FROM articles where id=?");
                if (!$stmt || !$stmt_articles){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->bind_param('s', $_POST['id_Value']);
                $stmt_articles->bind_param('s', $_POST['id_Value']);
                $stmt_articles->execute();
                $stmt_articles->close();
                $stmt->execute();
                $stmt->close();
                header("Location: home.php");
            } else{
        
            
        
                $stmt = $mysqli->prepare("SELECT username, description, body, url, upload_date FROM articles WHERE id ='" . $_POST['id_Value'] . "'");
                
                if (!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                
                $stmt->execute();
                $stmt->bind_result($username, $description,$body,$url,$upload_date);
                
                while($stmt->fetch()){
                
                
                    ?>  <form method="post">

                                <!--<img src="data:image/jpeg;base64,'.base64_encode( <?php //echo mysqli_fetch_array($image);?> ).'"/> -->
                                <h3>Description</h3>
                                <input name="description" required value="<?php echo(htmlentities($description)); ?>">
                                    <br>
                                <strong><?php echo($username);?></strong>
                                    <br>
                                <p>Body</p>
                                <input name="body" value="<?php echo($body); ?>"></input>
                                <p>URL Address</p>
                                <input name="body" value="<?php echo($url); ?>"></input>
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                            <input type="hidden" name="id_Value" value="<?php echo $_POST['id_Value'] ;?>">
                            <input type="hidden" name="edit_flag" value="edit_flag">
                            <input type="submit" name="Edit" value="Edit">
                        </form>
                        <form method="post">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                            <input type="hidden" name="id_Value" value="<?php echo $_POST['id_Value'] ;?>">
                            <input type="hidden" name="delete_flag" value="delete_flag">
                            <input type="submit" name="Delete" value="Delete">
                        </form>
                        <?php
            }
            }
             $stmt->close();   
            }
        }
        ?>