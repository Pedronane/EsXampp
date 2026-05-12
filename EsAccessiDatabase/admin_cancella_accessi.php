<?php
// Marchesi Pietro 5AI admin_cancella_accessi.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$message = '';
$accessi_eliminati = 0;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['dataLimite'])) {
    $dataLimite = $_POST['dataLimite'];

    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataLimite)) {
        $query = "DELETE FROM accessi WHERE DataInizio < :dataLimite;";
        $parametri = [":dataLimite" => $dataLimite];
        
        $result = eseguiUpdate($query, $parametri);

        if ($result !== null) {
            $accessi_eliminati = $result;
            $message = "Accessi eliminati con successo! Sono stati eliminati " . $accessi_eliminati . " accessi.";
        } else {
            $message = "Errore nell'eliminazione degli accessi";
        }
    } else {
        $message = "Data non valida";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cancella Accessi</title>
</head>
<body>
    <form method="POST" action="">
        <label for="dataLimite">Seleziona data limite:</label>
        <input type="date" id="dataLimite" name="dataLimite" required>
        <br><br>
        <input type="submit" value="Cancella Accessi">
    </form>

    <?php
    if (!empty($message)) {
        echo "<p>" . $message . "</p>";
    }
    ?>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
