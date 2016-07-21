<?php
session_start();
$target= "../filesite".$_SESSION['dmcdonnel']."/";
$target= $target . basename($_FILES['uploaded']['name']);

$ok=1;
if ($uploaded_type =="text/php"){
    Echo "Cannot upload php files";
    $ok=0;
}
if($ok==0){
    Echo "Your file was not uploaded";
    header ('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
} else {
    if(move_uploaded_file($FILES['uploaded']['tmp_name'], $target)){
        echo "The file " . basename($_FILES['uploadedfile']['name']). " has been uploaded";
    } else {
    echo "There was a problem uploading your file";
    }
    header ('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
}
