<?php
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

$accessi = null;
$utenteSelezionato = null;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['idUtente'])) {
    $idUtente = $_POST['idUtente'];

    $queryUtente = "SELECT idU, nome, cognome, email
                    FROM utenti
                    WHERE idU = :idUtente;";

    $parametriUtente = [":idUtente" => $idUtente];
    $datiUtente = eseguiSelect($queryUtente, $parametriUtente);

    if ($datiUtente != null && count($datiUtente) > 0) {
        $utenteSelezionato = $datiUtente[0];

        $queryAccessi = "SELECT DataInizio, OraInizio, DataFine, OraFine
                         FROM accessi
                         WHERE idU = :idUtente
                         ORDER BY DataInizio DESC, OraInizio DESC;";

        $accessi = eseguiSelect($queryAccessi, $parametriUtente);
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Accessi</title>
</head>
<body>
    <h1>Visualizza Accessi Utenti</h1>

    <form method="POST" action="">
        <label for="idUtente">Seleziona un utente:</label>
        <select name="idUtente" id="idUtente" required>
            <?php
            if ($utenti != null) {
                foreach ($utenti as $utente) {
                    echo "<option value='" . $utente['idU'] . "'>" . $utente['cognome'] . " " . $utente['nome'] . " - " . $utente['email'] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Visualizza Accessi">
    </form>

    <?php
    if ($utenteSelezionato != null) {

        if ($accessi != null && count($accessi) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Data Inizio</th>";
            echo "<th>Ora Inizio</th>";
            echo "<th>Data Fine</th>";
            echo "<th>Ora Fine</th>";
            echo "</tr>";

            foreach ($accessi as $accesso) {
                echo "<tr>";
                echo "<td>" . $accesso['DataInizio'] . "</td>";
                echo "<td>" . $accesso['OraInizio'] . "</td>";
                echo "<td>" . ($accesso['DataFine'] ?? '-') . "</td>";
                echo "<td>" . ($accesso['OraFine'] ?? '-') . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nessun accesso trovato per questo utente</p>";
        }
    }
    ?>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
