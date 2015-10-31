<?php

ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-errori.log");
error_log( "Hello, errors (2)!" );

include '../db_connect.php';
include '../functions.php';

$name = $_POST['name'];
$regolamento = $_POST['regolamento'];
$liberatoria = $_POST['liberatoria'];
$corso = $_POST['corso'];
$nascita = $_POST['nascita'];
$luogodinascita = $_POST['luogodinascita'];
$residenza = $_POST['residenza'];
$via = $_POST['via'];
$n = $_POST['n'];
$email = $_POST['email'];
$cap = $_POST['cap'];
$phone = $_POST['phone'];
$cf = $_POST['cf'];
$username = $_POST['username'];
$date = date ("d/m/y");

// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['regolamento']) 		||
   empty($_POST['corso']) 		||
   empty($_POST['nascita']) 		||
   empty($_POST['luogodinascita']) 		||
   empty($_POST['residenza']) 		||
   empty($_POST['via']) 		||
   empty($_POST['n']) 		||
   empty($_POST['cap']) 		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['cf'])	||
   empty($_POST['username'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "An error occurred!";
	error_log("error4 $name, $regolamento, $liberatoria, $corso, $nascita, $luogodinascita, $residenza, $via, $n, $cap, $phone, $cf, $date, $username and $email", 0);
	return false;
   }
	


error_log("$name, $regolamento, $liberatoria, $corso, $nascita, $luogodinascita, $residenza, $via, $n, $cap, $phone, $cf, $date, $username and $email", 0);

if ($insert_stmt = $mysqli->prepare("UPDATE members SET nascita=?, email=?, name=?, regolamento=?, liberatoria=?, corso=?, luogodinascita=?, residenza=?, via=?, numero=?, cap=?, phone=?, cf=?, date=? WHERE username=?")) {    
   $insert_stmt->bind_param('sssiiisssiiisss', $nascita, $email, $name, $regolamento, $liberatoria, $corso, $luogodinascita, $residenza, $via, $n, $cap, $phone, $cf, $date, $username); 

   // Esegui la query ottenuta.
   if(!$insert_stmt->execute()) {
     error_log("FAILURE!!! " . $insert_stmt->error);
     return false;
   } else {
     return true;
   }
};
?>
