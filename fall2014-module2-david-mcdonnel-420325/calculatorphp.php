    <?php
        $query1 = (float) $_POST['query1'];
        $query2 = (float) $_POST['query2'];
        function calculate($x,$y){
            if ($_POST['calculation']=="addition"){
                return $x+$y;
            } elseif ($_POST['calculation']=="subtraction"){
                return $x-$y;
            } elseif ($_POST['calculation']=="multiplication"){
                return $x*$y;
            } elseif ($_POST['calculation']=="division"){
                return $x/$y;
            }
        }
        echo "<link rel='stylesheet' type='text/css' href='./StyleSheet.css' />"; 
        echo "The answer is " . calculate($query1,$query2) . "!";
    ?>