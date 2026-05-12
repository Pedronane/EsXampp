<?php
// Marchesi Pietro 5AI admin_modifica_utente.php
require_once "conDB.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['tipo'] != 2) {
    header("Location: user.php");
}

$message = '';
$idUtente = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['idUtente']) ? intval($_POST['idUtente']) : 0);

if ($idUtente == 0) {
    header("Location: admin_gestisci_utenti.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = strtolower(trim($_POST['email']));
    $dataNascita = trim($_POST['dataNascita']);
    $sesso = trim($_POST['sesso']);
    $telefono = trim($_POST['telefono']);
    $residenza = trim($_POST['residenza']);
    $tipo = intval($_POST['tipo']);
    $password = trim($_POST['password']);

    if (!empty($password) && strlen($password) < 8) {
        $message = "La password deve avere almeno 8 caratteri";
    } else {
        if (!empty($password)) {
            $query = "UPDATE utenti SET nome=:nome, cognome=:cognome, email=:email,
                      dataNascita=:dataNascita, sesso=:sesso, telefono=:telefono,
                      residenza=:residenza, tipo=:tipo, password=:password WHERE idU=:id;";
            $parametri = [":nome"=>$nome,":cognome"=>$cognome,":email"=>$email,
                          ":dataNascita"=>$dataNascita,":sesso"=>$sesso,":telefono"=>$telefono,
                          ":residenza"=>$residenza,":tipo"=>$tipo,":password"=>$password,":id"=>$idUtente];
        } else {
            $query = "UPDATE utenti SET nome=:nome, cognome=:cognome, email=:email,
                      dataNascita=:dataNascita, sesso=:sesso, telefono=:telefono,
                      residenza=:residenza, tipo=:tipo WHERE idU=:id;";
            $parametri = [":nome"=>$nome,":cognome"=>$cognome,":email"=>$email,
                          ":dataNascita"=>$dataNascita,":sesso"=>$sesso,":telefono"=>$telefono,
                          ":residenza"=>$residenza,":tipo"=>$tipo,":id"=>$idUtente];
        }
        $ris = eseguiUpdate($query, $parametri);
        if ($ris !== null) {
            header("Location: admin_gestisci_utenti.php");
            exit;
        } else {
            $message = "Errore durante la modifica";
        }
    }
}

$dati = eseguiSelect("SELECT * FROM utenti WHERE idU = :id;", [":id" => $idUtente]);
if ($dati == null || count($dati) == 0) {
    header("Location: admin_gestisci_utenti.php");
    exit;
}
$utente = $dati[0];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Utente</title>
</head>
<body>
    <h1>Modifica Utente</h1>

    <?php if (!empty($message)) echo "<p>" . $message . "</p>"; ?>

    <form method="POST" action="">
        <input type="hidden" name="idUtente" value="<?php echo $idUtente; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
        Cognome: <input type="text" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
        Data di nascita: <input type="date" name="dataNascita" value="<?php echo $utente['dataNascita']; ?>" required><br>
        Sesso:
        <select name="sesso" required>
            <option value="M" <?php if($utente['sesso']=='M') echo 'selected'; ?>>Maschio</option>
            <option value="F" <?php if($utente['sesso']=='F') echo 'selected'; ?>>Femmina</option>
        </select><br>
        Telefono: <input type="tel" name="telefono" value="<?php echo $utente['telefono']; ?>"><br>
        Residenza: <input type="text" name="residenza" value="<?php echo $utente['residenza']; ?>"><br>
        Tipo:
        <select name="tipo" required>
            <option value="1" <?php if($utente['tipo']==1) echo 'selected'; ?>>User</option>
            <option value="2" <?php if($utente['tipo']==2) echo 'selected'; ?>>Admin</option>
        </select><br>
        Nuova password (lascia vuoto per non cambiare): <input type="password" name="password"><br>
        <input type="submit" value="Salva modifiche">
    </form>

    <br>
    <a href="admin_gestisci_utenti.php">Torna alla lista utenti</a>
    <a href="logout.php">Logout</a>
</body>
</html>
