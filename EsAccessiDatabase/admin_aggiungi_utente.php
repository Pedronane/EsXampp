<?php
// Marchesi Pietro 5AI admin_aggiungi_utente.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : '';
    $email = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : '';
    $dataNascita = isset($_POST['dataNascita']) ? trim($_POST['dataNascita']) : '';
    $sesso = isset($_POST['sesso']) ? trim($_POST['sesso']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $tipo = isset($_POST['tipo']) ? intval($_POST['tipo']) : 0;
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $residenza = isset($_POST['residenza']) ? trim($_POST['residenza']) : '';

    if (empty($nome) || empty($cognome) || empty($email) || empty($dataNascita) || 
        empty($sesso) || empty($password) || empty($telefono) || empty($residenza) || $tipo == 0) {
        $message = "Compila tutti i campi";
    } elseif (strlen($password) < 8) {
        $message = "La password deve avere almeno 8 caratteri";
    } elseif ($sesso !== 'M' && $sesso !== 'F') {
        $message = "Sesso non valido";
    } elseif ($tipo !== 1 && $tipo !== 2) {
        $message = "Tipo di account non valido";
    } else {
        $queryCheck = "SELECT idU FROM utenti WHERE email = :email;";
        $parametriCheck = [":email" => $email];
        $resultCheck = eseguiSelect($queryCheck, $parametriCheck);

        if ($resultCheck != null && count($resultCheck) > 0) {
            $message = "Email già registrata";
        } else {
            $queryCheckTel = "SELECT idU FROM utenti WHERE telefono = :telefono;";
            $parametriCheckTel = [":telefono" => $telefono];
            $resultCheckTel = eseguiSelect($queryCheckTel, $parametriCheckTel);

            if ($resultCheckTel != null && count($resultCheckTel) > 0) {
                $message = "Telefono già registrato";
            } else {
                $query = "INSERT INTO utenti (idU, nome, cognome, dataNascita, sesso, email, password, telefono, residenza, tipo)
                          VALUES (NULL, :nome, :cognome, :dataNascita, :sesso, :email, :password, :telefono, :residenza, :tipo);";

                $parametri = [
                    ":nome" => $nome,
                    ":cognome" => $cognome,
                    ":dataNascita" => $dataNascita,
                    ":sesso" => $sesso,
                    ":email" => $email,
                    ":password" => $password,
                    ":telefono" => $telefono,
                    ":residenza" => $residenza,
                    ":tipo" => $tipo
                ];

                $result = eseguiInsert($query, $parametri);

                if ($result !== null) {
                    $message = "Utente aggiunto con successo!";
                    $_POST = [];
                } else {
                    $message = "Errore nell'aggiunta dell'utente";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aggiungi Utente</title>
</head>
<body>

    <?php
    if (!empty($message)) {
        echo "<p>" . $message . "</p>";
    }
    ?>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Nome" required>
        <br>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" placeholder="Cognome" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="user@email.com" required>
        <br>

        <label for="dataNascita">Data di nascita:</label>
        <input type="date" id="dataNascita" name="dataNascita" required>
        <br>

        <label for="sesso">Sesso:</label>
        <select id="sesso" name="sesso" required>
            <option value="">Seleziona</option>
            <option value="M">Maschio</option>
            <option value="F">Femmina</option>
        </select>
        <br>

        <label for="password">Password (min 8 caratteri):</label>
        <input type="password" id="password" name="password" placeholder="Password" minlength="8" required>
        <br>

        <label for="tipo">Tipo di account:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Seleziona</option>
            <option value="1">User</option>
            <option value="2">Admin</option>
        </select>
        <br>

        <label for="telefono">Telefono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Telefono" required>
        <br>

        <label for="residenza">Residenza:</label>
        <input type="text" id="residenza" name="residenza" placeholder="Città/Indirizzo" required>
        <br>

        <input type="submit" value="Aggiungi Utente">
        <input type="reset" value="Cancella">
    </form>

    <br>
    <a href="admin.php">Torna al Pannello</a>
    <a href="logout.php">Logout</a>
</body>
</html>
