<?php
include_once "conDB.php";

function getUser($mail, $passwd)
{
    $query = "SELECT * FROM utenti WHERE email = :mail AND password = :passwd;";
    $parametri = [
        ":mail" => $mail,
        ":passwd" => $passwd
    ];
    $user = eseguiSelect($query, $parametri);
    return $user;
}

$check = false;
$user = null;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {
    if (isset($_POST['mail']) && isset($_POST['passwd'])) {
        $mail = strtolower(trim($_POST['mail']));
        $passwd = trim($_POST['passwd']);
        $user = getUser($mail, $passwd);
    }
}

session_start();
setcookie("error", "", time() - 1);

if ($user != null && count($user) > 0) {
    $userId = $user[0]['idU'];
    $tipo = $user[0]['tipo'];

    $_SESSION['userId'] = $user[0]['idU'];
    $_SESSION['tipo'] = $user[0]['tipo'];
    $_SESSION['nome'] = $user[0]['nome'];
    $_SESSION['cognome'] = $user[0]['cognome'];
    $_SESSION['email'] = $user[0]['email']; // Non serve però metti che serva dopo

    if ($tipo == 1)
        $page = 'user';
    else
        $page = 'admin';

    $dataInizio = date("Y-m-d");
    $oraInizio = date("H:i:s");

    $query = "INSERT INTO accessi (idA, DataInizio, OraInizio, DataFine, OraFine, idU)
              VALUES (NULL, :dataInizio, :oraInizio, NULL, NULL, :userId);";

    $parametri = [
        ":dataInizio" => $dataInizio,
        ":oraInizio" => $oraInizio,
        ":userId" => $userId
    ];

    $idAccesso = eseguiInsert($query, $parametri);
    $_SESSION['idAccesso'] = $idAccesso;

    header("Location:$page.php");
} else {
    setcookie("error", "E-mail o password errati", time() + 3600);
    header("Location:login.php");
}
?>