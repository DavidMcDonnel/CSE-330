<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en">
     <head>
         <meta charset="utf-8"/>
         <title>News Home</title>
         <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
     </head>
     <body class="home">
          <?php if(isset($_SESSION['username'])){ ?>
          <form action='addArticle.php' method='post'>
               <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
               <input type='submit' name='Upload' value='Upload'/>
          </form>
          <?php }
          require 'login.php';
     
     if(isset($_SESSION['uploaded'])){
          echo "Your page has been uploaded. \n";
          $_SESSION['uploaded']=null;
     }

     $stmt=$mysqli->prepare("SELECT id,username,description,upload_date FROM articles ORDER BY upload_date DESC");
     
     if (!$stmt){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
     }
     $stmt->execute();
     $result=$stmt->get_result();
     while($row=$result->fetch_assoc()){
          ?><form action="article.php" id="<?php echo htmlentities($row['id']) ;?>" method="post">
                    <article>
                         <br>
                        <input type="hidden" name="id_Value" value="<?php echo htmlentities($row['id']) ;?>">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                        <a onclick="document.getElementById('<?php echo $row['id'];?>').submit();"><?php echo htmlentities($row['description']) ; ?></a>
                        <br>
                        <!--<strong><?php //echo htmlentities($row['username']) ;?></strong>-->
                        <b><?php echo date($row['upload_date']);?></b>
                        <br>
                    </article>
                </form>
                <form action="userpage.php" method="post" id="<?php echo htmlentities($row['username']) ;?>">
                    <br>
                    <input type="hidden" name="username" value="<?php echo htmlentities($row['username']) ;?>">
                    <a onclick="document.getElementById('<?php echo $row['username'];?>').submit();"><?php echo htmlentities($row['username']) ;?></a>
                </form>
                <?php
                if(isset($_SESSION['username'])){
                if($_SESSION['username']===$row['username']){ ?>
               <form action="editArticle.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
                    <input type="hidden" name="id_Value" value="<?php echo $row['id'];?>">
                    <input type="submit" name="Edit" value="Edit">
               </form><?php
               
                         }
                }
          
     }
     $stmt->close();

?>

     </body>
</html>