<?php
/**ave it as sendnotifications.php and at the command line, run
* php sendnotifications.php
*
* - Upload it to a web host and load mywebhost.com/sendnotifications.php
* in a web browser.
* - Download a local server like WAMP, MAMP or XAMPP. Point the web root
* directory to the folder containing this file, and load
* localhost:8888/sendnotifications.php in a web browser.
*/
// Step 1: Download the Twilio-PHP library from twilio.com/docs/libraries,
// and move it into the folder containing this file.
require "/home/shawneegao/public_html/dmcdonnel-fall2014-module8-david-mcdonnel-420325-shawnee-gao/twilio-php-master/Services/Twilio.php";
require "database.php";
session_start();

// Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account
$AccountSid = "ACa569a19f60f802118d1e939a32ad9a34";
$AuthToken = "da2c6aae4f8184d5602b3a29f4439d0f";
// Step 3: instantiate a new Twilio Rest Client
$client = new Services_Twilio($AccountSid, $AuthToken);
// Step 4: make an array of people we know, to send them a message.
// Feel free to change/add your own phone number and name here.
if(!isset($_GET['username'])&&isset($_SESSION['userid'])){
$stmt = $mysqli->prepare("select username, phone from user where id=?");
$stmt->bind_param('i', $_SESSION['userid']);
$stmt->execute();
$stmt->bind_result($name, $number);
$stmt->fetch();
$stmt->close();
echo "This is : $name";
echo "This number : $number";
}
$people = array(
//"+13149336143" => "PetOwner",
$number => $name,
//"+14158675311" => "Virgil",
);
// Step 5: Loop over all our friends. $number is a phone number above, and
// $name is the name next to it
foreach ($people as $number => $name) {
$sms = $client->account->messages->sendMessage(
// Step 6: Change the 'From' number below to be a valid Twilio number
// that you've purchased, or the (deprecated) Sandbox number
"314-596-9105",
// the number we are sending to - Any phone number
$number,
// the sms body
"Hey $name, Here is your order confirmation blah blah blah!"
);
// Display a confirmation message on the screen
echo "Sent message to $name";
}
?>
