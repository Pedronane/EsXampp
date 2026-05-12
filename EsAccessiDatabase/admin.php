<?php
// Marchesi Pietro 5AI admin.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$userId = $_SESSION['userId'];
$queryUltimo = "SELECT DataInizio, OraInizio FROM accessi
                WHERE idU = :userId AND idA != :idAccesso
                ORDER BY DataInizio DESC, OraInizio DESC LIMIT 1;";
$ultimoAccesso = eseguiSelect($queryUltimo, [":userId" => $userId, ":idAccesso" => $_SESSION['idAccesso']]);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Area Admin</title>
</head>
<body>
    <h1>Pannello di Controllo Admin</h1>
    <p>Benvenuto <?php echo $_SESSION['nome'] . " " . $_SESSION['cognome']; ?></p>
    <?php
    if ($ultimoAccesso != null && count($ultimoAccesso) > 0)
        echo "<p>Ultimo accesso: " . $ultimoAccesso[0]['DataInizio'] . " alle " . $ultimoAccesso[0]['OraInizio'] . "</p>";
    else
        echo "<p>Primo accesso</p>";
    ?>

    <h2>Seleziona un'opzione:</h2>
    <ul>
        <li><a href="admin_visualizza_accessi.php">Visualizza Accessi Utenti</a></li>
        <li><a href="admin_gestisci_utenti.php">Gestisci Utenti</a></li>
        <li><a href="admin_cancella_accessi.php">Cancella Accessi Antecedenti a una Data</a></li>
        <li><a href="admin_aggiungi_utente.php">Aggiungi Nuovo Utente</a></li>
        <li><a href="admin_report.php">Report Statistici</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
