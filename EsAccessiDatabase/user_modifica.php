<?php
// Marchesi Pietro 5AI user_modifica.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 1) {
    header("Location: admin.php");
}

$userId = $_SESSION['userId'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = strtolower(trim($_POST['email']));
    $dataNascita = trim($_POST['dataNascita']);
    $sesso = trim($_POST['sesso']);
    $telefono = trim($_POST['telefono']);
    $residenza = trim($_POST['residenza']);
    $password = trim($_POST['password']);

    if (!empty($password) && strlen($password) < 8) {
        $message = "La password deve avere almeno 8 caratteri";
    } else {
        if (!empty($password)) {
            $query = "UPDATE utenti SET nome=:nome, cognome=:cognome, email=:email,
                      dataNascita=:dataNascita, sesso=:sesso, telefono=:telefono,
                      residenza=:residenza, password=:password WHERE idU=:id;";
            $parametri = [":nome"=>$nome,":cognome"=>$cognome,":email"=>$email,
                          ":dataNascita"=>$dataNascita,":sesso"=>$sesso,":telefono"=>$telefono,
                          ":residenza"=>$residenza,":password"=>$password,":id"=>$userId];
        } else {
            $query = "UPDATE utenti SET nome=:nome, cognome=:cognome, email=:email,
                      dataNascita=:dataNascita, sesso=:sesso, telefono=:telefono,
                      residenza=:residenza WHERE idU=:id;";
            $parametri = [":nome"=>$nome,":cognome"=>$cognome,":email"=>$email,
                          ":dataNascita"=>$dataNascita,":sesso"=>$sesso,":telefono"=>$telefono,
                          ":residenza"=>$residenza,":id"=>$userId];
        }
        $ris = eseguiUpdate($query, $parametri);
        if ($ris !== null) {
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            header("Location: user.php");
            exit;
        } else {
            $message = "Errore durante la modifica";
        }
    }
}

$dati = eseguiSelect("SELECT * FROM utenti WHERE idU = :id;", [":id" => $userId]);
$utente = $dati[0];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Profilo</title>
</head>
<body>
    <h1>Modifica Profilo</h1>

    <?php if (!empty($message)) echo "<p>" . $message . "</p>"; ?>

    <form method="POST" action="">
        Nome: <input type="text" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
        Cognome: <input type="text" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
        Data di nascita: <input type="date" name="dataNascita" value="<?php echo $utente['dataNascita']; ?>" required><br>
        Sesso:
        <select name="sesso" required>
            <option value="M" <?php if($utente['sesso']=='M') echo 'selected'; ?>>Maschio</option>
            <option value="F" <?php if($utente['sesso']=='F') echo 'selected'; ?>>Femmina</option>
        </select><br>
        Telefono: <input type="tel" name="telefono" value="<?php echo $utente['telefono']; ?>" required><br>
        Residenza: <input type="text" name="residenza" value="<?php echo $utente['residenza']; ?>" required><br>
        Nuova password (lascia vuoto per non cambiare): <input type="password" name="password"><br>
        <input type="submit" value="Salva modifiche">
    </form>

    <br>
    <a href="user.php">Torna all'area utente</a>
</body>
</html>
