<?php
//for using this php file when we want to sent information to the database
$dbhost = 'localhost';
$dbuser = 'glazari';
$dbpass = 'KAJrY8Ct';
$dbname = 'glazari';
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
?>