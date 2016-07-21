<?php
date_default_timezone_set('America/Chicago');
$date = "Wed Oct 29 2014 01:30:00 GMT+0000";

            $time = strtotime(date('Y/m/d',(int) "Wed Oct 29 2014 01:30:00 GMT+0000"));
            
            $day=date('Y/m/d', strtotime(date('Y/m/d',(int) "Wed Oct 29 2014 01:30:00 GMT+0000")));
            $time=date('H:i:s',strtotime(date('Y/m/d',(int) "Wed Oct 29 2014 01:30:00 GMT+0000")));
            echo($day + ",aggh "+ $time);
            ?>