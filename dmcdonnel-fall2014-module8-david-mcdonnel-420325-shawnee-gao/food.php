<?php
require 'database.php';
session_start();
header("Content-Type: application/json");
$count = 0;
$stmt = $mysqli->prepare("select count(*) from animal");
if(!$stmt) {
echo json_encode(
array(
"success" => false,
"message" => $mysqli->error
)
);
exit;
}

$stmt -> execute();
$stmt -> bind_result($count);
$stmt -> fetch();
$stmt -> close();
$menu = array();
$sql = "SELECT `id`, `name`, `price`, `category`, `image`, 'age', 'breed' FROM `animal`";

if(isset($_POST['id'])) {
$sql .= " WHERE id = ".$_POST['id'];
} 

else if(isset($_POST['category']) && $_POST['category']!='default') {
$sql .= " WHERE category = '".$_POST['category']."'";
}


if(isset($_POST['order'])) {
if ($_POST['order'] == "price_inc") {
$sql .= " ORDER BY price ASC";
} else if ($_POST['order'] == "price_dec") {
$sql .= " ORDER BY price DESC";
} else if ($_POST['order'] == "rating") {
$sql .= " ORDER BY rating DESC";
} else {
$sql .= " ORDER BY name ASC";
}
}
 
if($count > 0) {
$stmt1 = $mysqli->prepare($sql);
$stmt1 -> execute();
$stmt1 -> bind_result($id, $name, $price, $category, $image, $age, $breed);

while ($stmt1 -> fetch()) {

array_push($menu, array(
"id" => $id,
"name" => $name,
"price" => $price,
"category" => $category,
"image" => $image,
"age"=>$age,
"breed"=>$breed,
)
);
}


$stmt1->close();

echo json_encode(
array(
"message" => $sql,
"success" => true,
"animal" => $menu,
"username" => $_SESSION['username']
)
);

} else {
echo json_encode(
array(
"success" => false,
"message" => "No animals match your specification!"
)
);
}
?>
