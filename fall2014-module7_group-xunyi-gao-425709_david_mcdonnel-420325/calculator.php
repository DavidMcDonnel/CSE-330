CTYPE html>
<head>
    <title>Calculator_ShawneeGao</title>
</head>

<body>
    <form method= "POST">
        
        <input type = "number" step = 0.00001 name = "n1">
        <input type = "number" step = 0.00001 name = "n2"><br>

        <input type = "radio" name = "op" value = "add" >Addition<br>
	<input type = "radio" name = "op" value = "sub" >Subtraction<br>
        <input type = "radio" name = "op" value = "mult" >Multiplication<br>
        <input type = "radio" name = "op" value = "divi" >Division<br>
        <input type = "submit" value = "Enter">
            
    </form>
<?php
$n1 = $_POST['n1'];
$n2 = $_POST['n2'];
$operations = $_POST['op'];


if($operations == 'add')
{
    $answer = $n1 + $n2;
    echo $answer;
}
if($operations == 'sub')
{
    $answer = $n1 - $n2;
    echo $answer;
}
if($operations == 'mult')
{
    $answer = $n1 * $n2;
    echo $answer;
}
if($operations == 'divi')
{ 
  if($n2 == "0"){
    echo '<p> Can not divide by zero! </p>';
}
    $answer = $n1 / $n2;
    echo $answer;
}

?>
</body>
</html>

