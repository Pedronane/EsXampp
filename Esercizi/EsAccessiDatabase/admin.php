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

$utenteSelezionato = null;
$accessi = null;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['idUtente'])) {
    $idUtente = $_POST['idUtente'];

    $queryUtente = "SELECT idU, nome, cognome, email
                    FROM utenti
                    WHERE idU = :idUtente;";

    $parametriUtente = [
        ":idUtente" => $idUtente
    ];

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
    <title>Area admin</title>
</head>
<body>
    <h1>Pagina personale admin</h1>
    <p>Benvenuto <?php echo $_SESSION['nome'] . " " . $_SESSION['cognome']; ?></p>

    <h2>Seleziona un utente</h2>

    <form method="POST" action="">
        <select name="idUtente">
            <?php
            if ($utenti != null) {
                foreach ($utenti as $utente) {
                    echo "<option value='" . $utente['idU'] . "'>" . $utente['cognome'] . " " . $utente['nome'] . " - " . $utente['email'] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Visualizza accessi">
    </form>

    <?php
    if ($utenteSelezionato != null) {
        echo "<h2>Cronologia accessi di " . $utenteSelezionato['nome'] . " " . $utenteSelezionato['cognome'] . "</h2>";

        if ($accessi != null && count($accessi) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Data inizio</th>";
            echo "<th>Ora inizio</th>";
            echo "<th>Data fine</th>";
            echo "<th>Ora fine</th>";
            echo "</tr>";

            foreach ($accessi as $accesso) {
                echo "<tr>";
                echo "<td>" . $accesso['DataInizio'] . "</td>";
                echo "<td>" . $accesso['OraInizio'] . "</td>";
                echo "<td>" . $accesso['DataFine'] . "</td>";
                echo "<td>" . $accesso['OraFine'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nessun accesso trovato per questo utente</p>";
        }
    }
    ?>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>