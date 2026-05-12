<?php
// Marchesi Pietro 5AI admin_report.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$sezioneCercata = '';
$risultatiI = null;
$risultatiJ = null;
$risultatiK = null;
$risultatoL = null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sezioneCercata = $_POST['sezione'];

    if ($sezioneCercata == 'I') {
        $da = $_POST['da'];
        $a = $_POST['a'];
        $query = "SELECT u.nome, u.cognome, a.DataInizio, a.OraInizio, a.DataFine, a.OraFine
                  FROM accessi a JOIN utenti u ON a.idU = u.idU
                  WHERE a.DataInizio BETWEEN :da AND :a
                  ORDER BY u.cognome, u.nome, a.DataInizio, a.OraInizio;";
        $risultatiI = eseguiSelect($query, [":da" => $da, ":a" => $a]);

    } else if ($sezioneCercata == 'J') {
        $query = "SELECT DataInizio, COUNT(*) as totale
                  FROM accessi
                  GROUP BY DataInizio
                  ORDER BY DataInizio DESC;";
        $risultatiJ = eseguiSelect($query);

    } else if ($sezioneCercata == 'K') {
        $mese = intval($_POST['mese']);
        $anno = intval($_POST['anno']);
        $n = intval($_POST['n']);
        $query = "SELECT u.nome, u.cognome, COUNT(*) as totale
                  FROM accessi a JOIN utenti u ON a.idU = u.idU
                  WHERE MONTH(a.DataInizio) = :mese AND YEAR(a.DataInizio) = :anno
                  GROUP BY a.idU, u.nome, u.cognome
                  HAVING totale > :n
                  ORDER BY u.cognome, u.nome;";
        $risultatiK = eseguiSelect($query, [":mese" => $mese, ":anno" => $anno, ":n" => $n]);

    } else if ($sezioneCercata == 'L') {
        $query = "SELECT u.nome, u.cognome, a.DataInizio, a.OraInizio, a.DataFine, a.OraFine,
                         TIMESTAMPDIFF(SECOND, CONCAT(a.DataInizio,' ',a.OraInizio), CONCAT(a.DataFine,' ',a.OraFine)) as durata_sec
                  FROM accessi a JOIN utenti u ON a.idU = u.idU
                  WHERE a.DataFine IS NOT NULL AND a.OraFine IS NOT NULL
                  ORDER BY durata_sec DESC LIMIT 1;";
        $ris = eseguiSelect($query);
        if ($ris != null && count($ris) > 0)
            $risultatoL = $ris[0];
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Report Statistici</title>
</head>
<body>
    <h1>Report Statistici</h1>

    <h2>I - Ingressi compresi tra due date</h2>
    <form method="POST">
        <input type="hidden" name="sezione" value="I">
        Da: <input type="date" name="da" required>
        A: <input type="date" name="a" required>
        <input type="submit" value="Cerca">
    </form>
    <?php
    if ($sezioneCercata == 'I') {
        if ($risultatiI != null && count($risultatiI) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Nome</th><th>Cognome</th><th>Data Inizio</th><th>Ora Inizio</th><th>Data Fine</th><th>Ora Fine</th></tr>";
            foreach ($risultatiI as $r) {
                echo "<tr><td>".$r['nome']."</td><td>".$r['cognome']."</td><td>".$r['DataInizio']."</td><td>".$r['OraInizio']."</td><td>".($r['DataFine']??'-')."</td><td>".($r['OraFine']??'-')."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nessun risultato</p>";
        }
    }
    ?>

    <h2>J - Numero accessi per ogni giorno</h2>
    <form method="POST">
        <input type="hidden" name="sezione" value="J">
        <input type="submit" value="Mostra">
    </form>
    <?php
    if ($sezioneCercata == 'J') {
        if ($risultatiJ != null && count($risultatiJ) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Data</th><th>Numero Accessi</th></tr>";
            foreach ($risultatiJ as $r) {
                echo "<tr><td>".$r['DataInizio']."</td><td>".$r['totale']."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nessun accesso nel database</p>";
        }
    }
    ?>

    <h2>K - Utenti con più di N accessi in un mese</h2>
    <form method="POST">
        <input type="hidden" name="sezione" value="K">
        Mese: <input type="number" name="mese" min="1" max="12" required>
        Anno: <input type="number" name="anno" min="2000" required>
        N: <input type="number" name="n" min="0" required>
        <input type="submit" value="Cerca">
    </form>
    <?php
    if ($sezioneCercata == 'K') {
        if ($risultatiK != null && count($risultatiK) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Nome</th><th>Cognome</th><th>Totale accessi</th></tr>";
            foreach ($risultatiK as $r) {
                echo "<tr><td>".$r['nome']."</td><td>".$r['cognome']."</td><td>".$r['totale']."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nessun utente trovato</p>";
        }
    }
    ?>

    <h2>L - Accesso con durata massima</h2>
    <form method="POST">
        <input type="hidden" name="sezione" value="L">
        <input type="submit" value="Mostra">
    </form>
    <?php
    if ($sezioneCercata == 'L') {
        if ($risultatoL != null) {
            $ore = floor($risultatoL['durata_sec'] / 3600);
            $minuti = floor(($risultatoL['durata_sec'] % 3600) / 60);
            $secondi = $risultatoL['durata_sec'] % 60;
            echo "<p>Utente: " . $risultatoL['nome'] . " " . $risultatoL['cognome'] . "</p>";
            echo "<p>Inizio: " . $risultatoL['DataInizio'] . " " . $risultatoL['OraInizio'] . "</p>";
            echo "<p>Fine: " . $risultatoL['DataFine'] . " " . $risultatoL['OraFine'] . "</p>";
            echo "<p>Durata: " . $ore . "h " . $minuti . "m " . $secondi . "s</p>";
        } else {
            echo "<p>Nessun accesso completato trovato</p>";
        }
    }
    ?>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
