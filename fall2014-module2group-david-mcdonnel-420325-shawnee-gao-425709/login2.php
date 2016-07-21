<?php 

session_start();

//a file with all the user's names: shawneegao superman airbenders (they're all on the same line separated by a space so explode function can work)

$allUsers = file_get_contents("./users.txt");
//explode function splices the string with the delimited being ' ' and places them into an array
$username = explode (' ', $allUsers);

foreach ($username as $person=>$value){
//set session variable to equal the correct usernames in the users.txt and compares it with the post variable pulled from the html form
$_SESSION ['username'] = $value;


if ($_SESSION['username'] == $_POST ['formUser']){
//i used my calc.php file as a place holder for new location
header ('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/home.php');
break 2;
}
else {
    $_SESSION['badLogin']=true;
header ('Location: http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/Login.php');
//break 2;
}
}
?>