<?php
// Marchesi Pietro 5AI user.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 1) {
    header("Location: admin.php");
}

$userId = $_SESSION['userId'];

$query = "SELECT DataInizio, OraInizio, DataFine, OraFine
          FROM accessi
          WHERE idU = :userId
          ORDER BY DataInizio DESC, OraInizio DESC;";

$parametri = [":userId" => $userId];
$accessi = eseguiSelect($query, $parametri);

$queryUltimo = "SELECT DataInizio, OraInizio FROM accessi
                WHERE idU = :userId AND idA != :idAccesso
                ORDER BY DataInizio DESC, OraInizio DESC LIMIT 1;";
$ultimoAccesso = eseguiSelect($queryUltimo, [":userId" => $userId, ":idAccesso" => $_SESSION['idAccesso']]);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Area utente</title>
</head>
<body>
    <h1>Pagina personale utente</h1>
    <p>Benvenuto <?php echo $_SESSION['nome'] . " " . $_SESSION['cognome']; ?></p>
    <?php
    if ($ultimoAccesso != null && count($ultimoAccesso) > 0)
        echo "<p>Ultimo accesso: " . $ultimoAccesso[0]['DataInizio'] . " alle " . $ultimoAccesso[0]['OraInizio'] . "</p>";
    else
        echo "<p>Primo accesso</p>";
    ?>
    <a href="user_modifica.php">Modifica profilo</a>

    <h2>Cronologia accessi</h2>

    <?php
    if ($accessi != null && count($accessi) > 0) {
    ?>
        <table border='1'>
            <tr>
                <th>Data inizio</th>
                <th>Ora inizio</th>
                <th>Data fine</th>
                <th>Ora fine</th>
            </tr>
    <?php
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
        echo "<p>Nessun accesso trovato</p>";
    }
    ?>

    <br>
    <a href="logout.php">Logout</a>

</body>
</html>