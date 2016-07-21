<?php
session_start();
if(isset($_SESSION['userid'])){
echo json_encode(
array(
"loggedin"=>true,
"username"=>$_SESSION['username'],
"fb"=>$_SESSION['fb']
)
);
exit;
}
else{
echo json_encode(
array(
"loggedin"=>false
)
);
exit;
}
?>
