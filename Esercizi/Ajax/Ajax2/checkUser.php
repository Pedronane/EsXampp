<?php
// Marchesi Pietro 5AI checkUser.php 04/03/2025
session_start();
function controllaDati() {
    $result = "";
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){
        if (isset($_POST['user']) && isset($_POST['passwd'])) {
            $data = file("users.csv");
            foreach($data as $c){
                [$username, $password, $nome, $cognome, $s, $dN] = explode(':', trim($c), 6);
                if (strtolower($_POST['user']) == $u && $_POST['passwd'] == $p) {
                    $result = true;
                    $_SESSION['user'] = trim($username);
                }
            }
        }
    }
    return $result;
}

function findUser($user){
    $result = "";
    $data = file("users.csv");
    foreach($data as $c){
        [$username, $password, $nome, $cognome, $s, $dN] = explode(':', trim($c), 6);
        if ($user == $u) {
            $result = explode(':', trim($c), 6);
        }
    }
}
?>
