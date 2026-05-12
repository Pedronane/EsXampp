<?php
// Marchesi Pietro 5AI admin_visualizza_accessi.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$queryUtenti = "SELECT idU, nome, cognome, email
                FROM utenti
                WHERE tipo = 1
                ORDER BY cognome, nome;";

$utenti = eseguiSelect($queryUtenti);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Accessi</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Visualizza Accessi Utenti</h1>

    <label for="idUtente">Seleziona un utente:</label>
    <select name="idUtente" id="idUtente" onchange="caricaAccessi(this.value)">
        <option value="">-- Seleziona --</option>
        <?php
        if ($utenti != null) {
            foreach ($utenti as $utente) {
                echo "<option value='" . $utente['idU'] . "'>" . $utente['cognome'] . " " . $utente['nome'] . " - " . $utente['email'] . "</option>";
            }
        }
        ?>
    </select>

    <div id="tabellaAccessi"><p>Seleziona un utente per vedere gli accessi</p></div>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
