<?php

ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php-error.log');
error_log('Hello, errors login!');
include 'db_connect.php';
include 'functions.php';
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
if (isset($_POST['username'], $_POST['p'])) {
    $username = $_POST['username'];
    $password = $_POST['p']; // Recupero la password criptata.
   if (login($username, $password, $mysqli) == true) {
       // Login eseguito
      header('Location: https://scuola.fantasiadanzarovigo.com/');
       $mysqli->query("UPDATE `members` SET `loggedin` = '1' where `members`.`username` = '$username'");
   } else {
       header('Location: https://scuola.fantasiadanzarovigo.com/?error=1');
   }
} else {
    // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
   echo 'Invalid Request';
}
