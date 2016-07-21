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
        
      <?php
      require 'login.php';
      $stmt=$mysqli->prepare("SELECT id,username, description,upload_date FROM articles where username= ? ORDER BY upload_date DESC");
      if (!$stmt){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
     }
     $stmt->bind_param('s',$_POST['username']);
     $stmt->execute();
     $result=$stmt->get_result();
     ?>
     <h3>Welcome to <?php echo htmlentities($_POST['username']);?>'s user page!</h3>
     <?php
     while($row=$result->fetch_assoc()){ ?>
    <form action="article.php" id="<?php echo htmlentities($row['id']) ;?>" method="post"> 
        <article>
           <input type="hidden" name="id_Value" value="<?php echo htmlentities($row['id']) ;?>">
           <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
           <a onclick="document.getElementById('<?php echo $row['id'];?>').submit();"><?php echo htmlentities($row['description']) ; ?></a>
           <br>
           <strong><?php echo htmlentities($row['username']) ;?></strong>
           <b><?php echo date($row['upload_date']);?></b>
           <br>
       </article>
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