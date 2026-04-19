<?php
/*
    ERR_CONN = errore connessione db
    [] = credenziali errate
    [brani] = credenziali corrette
*/
session_start();
require_once('funzioni.php');
if(!isset($_GET['cat'], $_SESSION['user']))
     header("location: login.php");
else{
    $user = $_SESSION['user'];
    $cat = $_GET['cat'];
    $query = "SELECT b.* from playlists AS p INNER JOIN brani AS b ON b.idBrano = p.idBrano WHERE idUtente = '$user' AND b.categoria = $cat ;";
    $braniUsr = eseguiQuery($query);
    if($braniUsr == 0)
        echo json_encode("ERR_CONN");
    else
        echo json_encode($braniUsr);
}
?>