<?php
include_once "funzioni.php";

function controllaDati() {
    $result = false;
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){
        if (isset($_POST['user']) && isset($_POST['passwd'])) {
            $user = strtolower($_POST['user']); 
            $passwd = strtolower($_POST['passwd']); 
            $query = "SELECT * FROM utenti WHERE username=$user AND password=$passwd;";
            $check = eseguiQuery($query);
            if($check != null)
                $result = true;
        }
    }
    return $result;
}

    $check = controllaDati();
    session_start();
    setcookie("error","" , time() - 1);
    if ($check == true) {
        $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
        header("Location:index.php");
    }
    else {
        setcookie("error","Username or password wrong" , time() + 3600);
        header("Location:login.php");
    }
?>
