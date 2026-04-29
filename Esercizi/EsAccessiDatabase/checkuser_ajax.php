<?php
/*
    ERR_CONN = errore connessione db
    NO_USR   = credenziali errate
    OK_ADMIN = login admin ok
    OK_USR   = login utente ok
*/
require_once('conDB.php');

if(!isset($_POST['mail'], $_POST['passwd']))
    header("location: login.php");
else{
    $mail = strtolower(trim($_POST['mail']));
    $passwd = trim($_POST['passwd']);

    $query = "SELECT * FROM utenti WHERE email = :mail AND password = :passwd;";
    $parametri = [":mail" => $mail, ":passwd" => $passwd];
    $ris = eseguiSelect($query, $parametri);

    if($ris == null)
        echo json_encode("ERR_CONN");
    else if(count($ris) == 0)
        echo json_encode("NO_USR");
    else{
        session_start();
        $_SESSION['userId'] = $ris[0]['idU'];
        $_SESSION['tipo']   = $ris[0]['tipo'];
        $_SESSION['nome']   = $ris[0]['nome'];
        $_SESSION['cognome']= $ris[0]['cognome'];
        $_SESSION['email']  = $ris[0]['email'];

        $dataInizio = date("Y-m-d");
        $oraInizio  = date("H:i:s");

        $queryAcc = "INSERT INTO accessi (idA, DataInizio, OraInizio, DataFine, OraFine, idU)
                     VALUES (NULL, :dataInizio, :oraInizio, NULL, NULL, :idU);";
        $parametriAcc = [":dataInizio" => $dataInizio, ":oraInizio" => $oraInizio, ":idU" => $ris[0]['idU']];
        $idAccesso = eseguiInsert($queryAcc, $parametriAcc);
        $_SESSION['idAccesso'] = $idAccesso;

        if($ris[0]['tipo'] == 2)
            echo json_encode("OK_ADMIN");
        else
            echo json_encode("OK_USR");
    }
}
?>
