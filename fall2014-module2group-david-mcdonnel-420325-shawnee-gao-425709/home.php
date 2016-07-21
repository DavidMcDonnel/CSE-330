<?php
session_start();
ini_set();

$files=array();
$directory="./filesite/" . $_SESSION['username'];
$filepath=glob("./filesite/" . $_SESSION['username'] . "*.*");

foreach($filepath as $file){
    $files[]=$file;
}
$directory='./filesite/' . $_SESSION['username'];
$dir=new RecursiveDirectoryIterator($directory,FilesystemIterator::SKIP_DOTS);
$it=new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST);
$it->setMaxDepth(1);
foreach($it as $fileinfo){
    if($fileinfo->isDir()){
        //USE THIS FOR FOLDERS
    } elseif ($fileinfo->isFile()){
        $files[]=$fileinfo->getFilename();
    }
}


function createList($x){
    $ans="";
    foreach($x as $item){
        $escapedItem=implode($item);
        $ans .= '<a class="iframeLink" target="iFrame" href="http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/filesite/' . $_SESSION['username'] . '/'. $escapedItem . '">'.$item.'</a>
                    <br>';
        $ans .= '<form action= "http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/deleter.php" method="post">
                    <br>';
        $ans .= '   <label>Delete<input type="submit" name ="delete" value="'.$item.'"/></label>
                    <br>';
        $ans .= '</form>';
            
    }
    return $ans;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
</head>

<body class="home">
    <div class="logout">
        <form action="http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/logout.php" method="post">
            <input type="submit" value="Logout"/>
        </form>
    </div>
    <div class="files">
       <?php echo createList($files); ?>
    
    </div>
    <div class="upload">
        <form action="upload_file.php" method="post" enctype="multipart/form-data">

            <input type="file" name="file"/>
        
            <br />
            
            <input type="submit" value="Upload" />
    
        </form>
    </div>
    <iframe name="iFrame"></iframe>
    



</body>
</html>