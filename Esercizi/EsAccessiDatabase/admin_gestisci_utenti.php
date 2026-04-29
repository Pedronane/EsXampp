<?php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$queryUtenti = "SELECT idU, nome, cognome, email, telefono
                FROM utenti
                WHERE tipo = 1
                ORDER BY cognome, nome;";

$utenti = eseguiSelect($queryUtenti);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['idUtente'])) {
    $idUtente = $_POST['idUtente'];

    $queryDeleteAccessi = "DELETE FROM accessi WHERE idU = :idUtente;";
    $parametriAccessi = [":idUtente" => $idUtente];
    eseguiUpdate($queryDeleteAccessi, $parametriAccessi);

    $queryDelete = "DELETE FROM utenti WHERE idU = :idUtente;";
    $parametri = [":idUtente" => $idUtente];
    $result = eseguiUpdate($queryDelete, $parametri);

    if ($result !== null && $result > 0) {
        $message = "Utente eliminato con successo!";
        $utenti = eseguiSelect($queryUtenti);
    } else {
        $message = "Errore nell'eliminazione dell'utente";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestisci Utenti</title>
</head>
<body>
    <h1>Gestisci Utenti</h1>

    <?php
    if (!empty($message)) {
        echo "<p>" . $message . "</p>";
    }

    if ($utenti != null && count($utenti) > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Nome</th>";
        echo "<th>Cognome</th>";
        echo "<th>Email</th>";
        echo "<th>Telefono</th>";
        echo "<th>Azione</th>";
        echo "</tr>";

        foreach ($utenti as $utente) {
            echo "<tr>";
            echo "<td>" . $utente['nome'] . "</td>";
            echo "<td>" . $utente['cognome'] . "</td>";
            echo "<td>" . $utente['email'] . "</td>";
            echo "<td>" . $utente['telefono'] . "</td>";
            echo "<td>";
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='idUtente' value='" . $utente['idU'] . "'>";
            echo "<input type='submit' value='Elimina'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nessun utente trovato</p>";
    }
    ?>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
