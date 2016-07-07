<?php

ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php-error_adm.log');
error_log('Hello, errors (3)!');

include 'db_connect.php';
include 'functions.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['p'];
error_log("action is $action and username is $username");

if ($action == '' && $username != '' && $password != '' && $username != 'admin') {
    $regolamento = '0';
 // Crea una chiave casuale
 $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 // Crea una password usando la chiave appena creata.
 $password = hash('sha512', $password.$random_salt);
 // Inserisci a questo punto il codice SQL per eseguire la INSERT nel tuo database
 // Assicurati di usare statement SQL 'prepared'.
 if ($insert_stmt = $mysqli->prepare('INSERT INTO members (username, password, salt, regolamento) VALUES (?, ?, ?, ?)')) {
     $insert_stmt->bind_param('ssss', $username, $password, $random_salt, $regolamento);
    // Esegui la query ottenuta.
    $insert_stmt->execute();
 }
}

if ($action == 'del' && $username != '') {
    if ($insert_stmt = $mysqli->prepare('DELETE from members WHERE username=?')) {
        $insert_stmt->bind_param('s', $username);
    // Esegui la query ottenuta.
    $insert_stmt->execute();
    }
}

if ($action == 'pass' && $username != '' && $password != '') {

 // Crea una chiave casuale
 $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 // Crea una password usando la chiave appena creata.
 $password = hash('sha512', $password.$random_salt);
 // Inserisci a questo punto il codice SQL per eseguire la INSERT nel tuo database
 // Assicurati di usare statement SQL 'prepared'.
 if ($insert_stmt = $mysqli->prepare('UPDATE members set password=?, salt=? WHERE username=?')) {
     $insert_stmt->bind_param('sss', $password, $random_salt, $username);
    // Esegui la query ottenuta.
    $insert_stmt->execute();
 }
}
header('Location: https://scuola.fantasiadanzarovigo.com/');
