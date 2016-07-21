<?php

$mysqli = new mysqli('localhost', 'php', 'module3', 'battlefield');
 
    if($mysqli->connect_errno) {
            printf("Connection Failed: %s\n", $mysqli->connect_error);
            exit;
    }
    
$stmt=$mysqli->prepare("SELECT TOP 5 critique FROM reports ORDER BY posted DESC");
$stmt2=$mysqli->prepare("SELECT soldiers,avg(ammo/duration) as average FROM reports GROUP BY soldiers  ORDER BY soldiers DESC");

if (!$stmt || !$stmt2){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
}

$result=$stmt->get_result();

?>

<!DOCTYPE html>
<head>
<title>Battlefield Analysis</title>
<style type="text/css">
body{
	width: 760px; /* how wide to make your web page */
	background-color: teal; /* what color to make the background */
	margin: 0 auto;
	padding: 0;
	font:12px/16px Verdana, sans-serif; /* default font */
}
div#main{
	background-color: #FFF;
	margin: 0;
	padding: 10px;
}
div.h1{
    text-align: center;
}
</style>
</head>
<body><div id="main">
 
    <h1>Battlefield Analysis</h1>
    
    <h2>Latest Critiques</h2>
    
    <ul>
        
        <?php
        while($row=$result->fetch_assoc()){
            echo "<li>"+ htmlentities($row['critique'])+ "</li>";
        }
        $stmt->close();
        $result2=$stmt2->get_result();
        ?>
    </ul>
    
    <h2>Battle Statistics</h2>
    <table>
        <?php
        while($row=$result->fetch_assoc()){
        echo "<tr>";
        echo "    <label>Number of Soldiers<td></td>"+htmlentities($row['soldiers'])+"</label>";
        echo "    <label>Pounds of Ammunition per Second<td>"+htmlentities($row['average'])+"</td></label>";
        echo "</tr>";
        }
        ?>
    </table>
    <a href="batlefield-submit.html">Submit a New Battle Report</a>
    
    
 
</div></body>
</html>