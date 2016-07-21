<?php
$URL = "http://ec2-54-68-21-15.us-west-2.compute.amazonaws.com/~dmcdonnel/Login.php";
$base = '<base href="'.$URL.'">';
$host = preg_replace('/^[^\/]+\/\//','',$URL);
$tarray = explode('/',$host);
$host = array_shift($tarray);
$URI = '/' . implode('/',$tarray);
$content = '';
$fp = @fsockopen($host,80,$errno,$errstr,30);
if(!$fp) { echo "Unable to open socked: $errstr ($errno)\n"; exit; } 
fwrite($fp,"GET $URI HTTP/1.0\r\n");
fwrite($fp,"Host: $host\r\n");
if( isset($_SERVER["HTTP_USER_AGENT"]) ) { fwrite($fp,'User-Agent: '.$_SERVER["HTTP_USER_AGENT"]."\r\n"); }
fwrite($fp,"Connection: Close\r\n");
fwrite($fp,"\r\n");
while (!feof($fp)) { $content .= fgets($fp, 128); }
fclose($fp);
if( strpos($content,"\r\n") > 0 ) { $eolchar = "\r\n"; }
else { $eolchar = "\n"; }
$eolpos = strpos($content,"$eolchar$eolchar");
$content = substr($content,($eolpos + strlen("$eolchar$eolchar")));
if( preg_match('/<head\s*>/i',$content) ) { echo( preg_replace('/<head\s*>/i','<head>'.$base,$content,1) ); }
else { echo( preg_replace('/<([a-z])([^>]+)>/i',"<\\1\\2>".$base,$content,1) ); }
?>
