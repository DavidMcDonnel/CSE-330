<?php
session_start();
?>
        <!DOCTYPE html>
        
        <html lang="en">
             <head>
                 <meta charset="utf-8"/>
                 <title>Article</title>
                 <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
             </head>
             <body class="article">
                <a href="home.php">Return Home</a>
<?php

require 'login.php';


    if(isset($_SESSION['token']) && $_SESSION['token']!==$_POST['token']){
       die("Request forgery detected");
    }else{
        if(isset($_POST['add_comment'])){
            $comment_stmt = $mysqli->prepare("INSERT INTO comments (username,comment,article_id,upload_date) VALUES (?,?,?,now())");
            
            if (!$comment_stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
            $comment_stmt->bind_param('sss',$_SESSION['username'],$_POST['comment_value'],$_POST['id_Value']);
            $comment_stmt->execute();
            $comment_stmt->close();
                header('Location: home.php');
        }
             }
             
    if(isset($_SESSION['token']) && $_SESSION['token']!==$_POST['token']){
        die("Request forgery detected");
    }else{
            
            if(isset($_POST['delete_comment'])){
            $delete_comment_stmt = $mysqli->prepare("DELETE FROM comments where id=?");
            
            if (!$delete_comment_stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
            
            $delete_comment_stmt->bind_param('s', $_POST['comment_id_Value']);
            $delete_comment_stmt->execute();
            $delete_comment_stmt->close();
            header('Location: home.php');
        }
    }
            
        $mysqli->autocommit(FALSE);
        
        $stmt = $mysqli->prepare("SELECT username, description, body, url, upload_date FROM articles WHERE id ='" . $_POST['id_Value']."'");
        $stmt2= $mysqli->prepare("SELECT id, username,comment,upload_date FROM comments where article_id= '". $_POST['id_Value']."' ORDER BY upload_date DESC");
        
        
        
        if ($stmt->execute() == false){
            echo 'First query failed: ' . $mysqli->error;
        }
        
        $stmt->bind_result($username, $description,$body,$url,$upload_date);

        while($stmt->fetch()){
                
?>

                        <h3><?php echo htmlentities($description); ?></h3>
                            <br>
                    <form action="userpage.php" method="post" id="<?php echo htmlentities($row['username']) ;?>">
                        
                        <a onclick="document.getElementById('<?php echo $row['username'];?>').submit();"><?php echo htmlentities($row['username']) ;?></a>
                        <input type="hidden" name="username" value="<?php echo htmlentities($row['username']) ;?>">
                    </form>
                            <br>
                        <h6><?php echo date($upload_date);?></h6>
                            <br>
                        <p><?php echo htmlentities($body) ; ?></p>
                        <?php if(isset($url)){ ?>
                        <a href="<?php echo htmlentities($url) ;?>"><?php echo htmlentities($url) ;?></a>
                        <?php } ?>
            <?php   if (isset($_SESSION['username'])){
                        if($_SESSION['username']===$username){ ?>
                <form action="editArticle.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                    <input type="hidden" name="id_Value"  value="<?php echo $_POST['id_Value']; ?>">
                    <input type="submit" name="Edit Article" value="Edit Article">
                </form>
                <?php
                        }
                    }
        }
        if (isset($_SESSION['username'])){
        ?><form action="article.php" method="post">
            <textarea class="comments" name="comment_value"></textarea>
            <br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
            <input type="hidden" name="add_comment" value="add_comment">
            <input type="hidden" name="id_Value" value="<?php echo $_POST['id_Value'];?>">
            <input type="submit" name="Comment" value="Comment">
        </form>
        <?php } else{ ?>
            <p>Please log in to comment</p>
        <?php   }?>
        <div class="scroll">
        <?php
        $stmt->close();
        
        if ($stmt2->execute() == false){
            echo 'Second query failed: ' . $mysqli->error;
        }
                $result=$stmt2->get_result();
        while($row = $result->fetch_assoc()){ ?>
            <strong><?php echo htmlentities($row['username']) ;?></strong>
            <p><?php echo htmlentities($row['comment']);?></p>
            <h6><?php echo date($row['upload_date']);?></h6>
            <br>
                <?php
                if(isset($_SESSION['username']) && $row['username']===$_SESSION['username']){ ?>
                <form action="article.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                    <input type="hidden" name="delete_comment" value="delete_comment">
                    <input type="hidden" name="comment_id_Value" value="<?php echo $row['id'];?>">
                    <input type="submit" name="Delete Comment" value="Delete Comment">
                </form>
               <?php
               }
                ?>
  <?php } ?>
        </div>
        
<?php    $stmt2->close();    ?>        
             </body>
        </html>