    <?php
        $query1 = (float) $_POST['query1'];
        $query2 = (float) $_POST['query2'];
        function calculate($x,$y){
            if ($_POST['calculation']==="addition"){
                return $x+$y;
            } elseif ($_POST['calculation']==="subtraction"){
                return $x-$y;
            } elseif ($_POST['calculation']==="multiplication"){
                return $x*$y;
            } elseif ($_POST['calculation']==="division"){
                return $x/$y;
            }
        }
    ?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>PHP Calculator</title>
    <link rel="stylesheet" type="text/css" href="./StyleSheet.css"/>
</head>

<body class="calculator">
    <form  method="post">
        <span class="span">
                <?php
                    if ((!is_null($_POST['query1'])) and (!is_null(calculate($query1,$query2)))){
                        echo "The answer is " . calculate($query1,$query2) . "!";
                    } elseif(!is_null($_POST['query1'])){echo "Cannot divide by zero";} else{}
                ?>
                <br>
            <label class="query">Input 1<input  class="query" type="number" step="0.000001" name="query1"/> </label>
            <label>Input 2<input class="query" type="number" step="0.000001" name="query2"/> </label>
        
        <br>
        <br>
        
            <label>Addition<input       class="radio"       type="radio" name="calculation"    value="addition"/></label>
            <label>Subtraction<input    class="radio"       type="radio" name="calculation"    value="subtraction"/></label>
        <br>
            <label>Multiplication<input class="radio"       type="radio" name="calculation"    value="multiplication"/></label>
            <label>Division<input       class="radio"       type="radio" name="calculation"    value="division"/></label>
        <br>
        
        <input class="radio"    type="submit" value= "calculate"/>
        </span>
    </form>
</body>
</html>
