<?php
include_once "conDB.php";

function controllaDati($mail, $passwd)
{
    $result = false;
    $query = "SELECT * FROM utenti WHERE email='$mail' AND password='$passwd';";
    $check = eseguiQuery($query);
    if ($check != null)
        $result = true;
    return $result;
}

$check = false;
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {
    if (isset($_POST['mail']) && isset($_POST['passwd'])) {
        $mail = strtolower($_POST['mail']);
        $passwd = strtolower($_POST['passwd']);
        $check = controllaDati($mail, $passwd);
    }
}
session_start();
setcookie("error", "", time() - 1);
if ($check == true) {
    $_SESSION['mail'] = ucfirst(strtolower($_POST['mail']));
    header("Location:index.php");
} else {
    setcookie("error", "E-mail or password wrong", time() + 3600);
    header("Location:login.php");
}
?>