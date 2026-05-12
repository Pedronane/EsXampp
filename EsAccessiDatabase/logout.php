<?php
require_once "conDB.php";
session_start();

if (isset($_SESSION['idAccesso'])) {
    $idAccesso = $_SESSION['idAccesso'];
    $dataFine = date("Y-m-d");
    $oraFine = date("H:i:s");

    $query = "UPDATE accessi
              SET DataFine = :dataFine, OraFine = :oraFine
              WHERE idA = :idAccesso;";

    $parametri = [
        ":dataFine" => $dataFine,
        ":oraFine" => $oraFine,
        ":idAccesso" => $idAccesso
    ];

    eseguiUpdate($query, $parametri);
}

session_destroy();
header("Location: login.php");
?>