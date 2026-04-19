<?php
/*
    ERR_CONN = errore connessione db
    NO_USR = credenziali errate
    OK_USR = credenziali corrette
*/
require_once('funzioni.php');
if(!isset($_POST['usr'], $_POST['psw']))
     header("location: login.php");
else{
    $username = $_POST['usr'];
    $password =  $_POST['psw'];
    $query = "SELECT username FROM utenti WHERE username = '$username' AND password = '$password';";
    $risUser = eseguiQuery($query);
    $risServer = null;
    if($risUser == 0)
        $risServer = "ERR_CONN";
    else if (count($risUser) == 0)
        $risServer = "NO_USR";
    else{
        $risServer = "OK_USR";
        session_start();
        $_SESSION['user'] = $risUser[0]['username'];
    }
    echo $risServer;
}