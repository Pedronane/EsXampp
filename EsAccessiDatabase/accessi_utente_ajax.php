<?php
// Marchesi Pietro 5AI accessi_utente_ajax.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['tipo'] != 2) {
    echo json_encode([]);
    exit;
}

if (!isset($_POST['idUtente']) || $_POST['idUtente'] == '') {
    echo json_encode([]);
    exit;
}

$idUtente = $_POST['idUtente'];
$query = "SELECT DataInizio, OraInizio, DataFine, OraFine
          FROM accessi
          WHERE idU = :idUtente
          ORDER BY DataInizio DESC, OraInizio DESC;";
$accessi = eseguiSelect($query, [":idUtente" => $idUtente]);

echo json_encode($accessi ?? []);
?>
