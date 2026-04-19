<?php
include_once "conDB.php";

function getUser($mail, $passwd)
{
    $query = "SELECT * FROM utenti WHERE email='$mail' AND password='$passwd';";
    $user = eseguiSelect($query);
    return $user;
}

$check = false;
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {
    if (isset($_POST['mail']) && isset($_POST['passwd'])) {
        $mail = strtolower($_POST['mail']);
        $passwd = strtolower($_POST['passwd']);
        $user = getUser($mail, $passwd);
    }
}
session_start();
setcookie("error", "", time() - 1);
if ($user != null) {
    $userId = $user[0]['idU'];
    $tipo = $user[0]['tipo'];
    $_SESSION['userId'] = $user[0]['idU'];
    $_SESSION['tipo'] = $user[0]['tipo'];
    if($user[0]['tipo'] == 1)
        $page = 'user';
    else
        $page = 'admin';
    $query = "INSERT INTO accessi (idA, DataInizio, OraInizio, DataFine, OraFine, idU) VALUES (NULL, ". date("yyyy:MM:dd") . ",".time().", NULL, NULL, $idU);";
    eseguiInsert($query);
    header("Location:$page.php");
} else {
    setcookie("error", "E-mail or password wrong", time() + 3600);
    header("Location:login.php");
}
?>
