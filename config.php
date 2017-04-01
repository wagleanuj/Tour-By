<?php
/*
@author: Anuj Wagle
this php file defines the database and establishes a connection to it
*/
$dbhost = '';
$dbuser = '';
$dbpass = '';

$db= new mysqli($dbhost,$dbuser,$dbpass,$dbuser);
if($db->connect_errno>0){
die('Unable to establish database connection :'.$db->connect_error);
}
?>

