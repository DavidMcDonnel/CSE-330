<?php
if (empty($_POST['val1']) || empty($_POST['val2']) || empty($_POST['val3']) || empty($_POST['val4']) || empty($_POST['val5'])) {
  header("Location: form.html");
  exit;
}
if (!isset($_POST['calc'])){
  header("Location: form.html");
  exit;
}else{
	if (isset($_POST['calc'])){
		if ($_POST['calc'] == "add") {
		  $result = $_POST['val1'] + $_POST['val2'] + $_POST['val3'] + $_POST['val4'] + $_POST['val5'];
		} elseif ($_POST['calc'] == "subtract") {
		  $result = $_POST['val1'] - $_POST['val2'] - $_POST['val3'] - $_POST['val4'] - $_POST['val5'];
		} elseif ($_POST['calc'] == "multiply") {
		  $result = $_POST['val1'] * $_POST['val2'] * $_POST['val3'] * $_POST['val4'] * $_POST['val5'];
		} elseif ($_POST['calc'] == "divide") {
		  $result = $_POST['val1'] / $_POST['val2'] / $_POST['val3'] / $_POST['val4'] / $_POST['val5'];
		} elseif ($_POST['calc'] == "Highest") {
			  $total= array();
			  $total[] =$_POST['val1'];
			  $total[] =$_POST['val2'];
			  $total[] =$_POST['val3'];
			  $total[] =$_POST['val4'];
			  $total[] =$_POST['val5']; 
			  $result = max($total);
		} elseif ($_POST['calc'] == "Lowest") {
			  $total= array();
			  $total[] =$_POST['val1'];
			  $total[] =$_POST['val2'];
			  $total[] =$_POST['val3'];
			  $total[] =$_POST['val4'];
			  $total[] =$_POST['val5']; 
			  $result = min($total);
		} elseif ($_POST['calc'] == "Average") { 			  
			  $result = (($_POST['val1'] + $_POST['val2'] + $_POST['val3'] + $_POST['val4'] + $_POST['val5'])/5);
		} elseif ($_POST['calc'] == "Sort in ascending order") {
			  $numbers= array();
			  $numbers[] =$_POST['val1'];
			  $numbers[] =$_POST['val2'];
			  $numbers[] =$_POST['val3'];
			  $numbers[] =$_POST['val4'];
			  $numbers[] =$_POST['val5'];
			  asort($numbers); 
			  $result = implode(', ',$numbers);
		}
	}
}
$display ="";
$display .="<p>The result of the calculation is: $result</p>";
$display .="<p><a href=\"form.html\" target=\"_self\">Do Another</a></p>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Calculation Result</title>
</head>
<body>
<?php 
if (isset($display)){ echo "$display"; }
?>
</body>
</html>
