<?php
// Marchesi Pietro 5AI checkUser.php 11/12/2025
function controllaDati() {
    $result = "nonuser";
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){
        if (isset($_POST['user']) && isset($_POST['passwd'])) {
            $user = strtolower(trim($_POST['user']));
            $passwd = trim($_POST['passwd']);
            if (file_exists("users.csv")) {
                $data = file("users.csv");
                foreach($data as $c){
                    $c = trim($c);
                    [$u, $p, $r] = explode(':', $c, 3);
                    if ($user == strtolower($u) && $passwd === $p) {
                        if(trim($r) == 'admin'){
                            $result = "admin";        
                        }
                        else {
                            $result = "user";
                        }
                        break;
                    }
                }
            }
        }
    }
    return $result;
}

// Si ipotizza che solo un user possa eseguire la registrazione
// Un admin può inserire le proprie credenziali direttamente in file
function registerUser(){
    $err = "";

    if (!isset($_POST['user']) || !isset($_POST['passwd']) || !isset($_POST['confirm'])) {
        $err = "Missing form data";
    }

    $username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : "";
    $passwd = isset($_POST['passwd']) ? trim($_POST['passwd']) : "";
    $confirm = isset($_POST['confirm']) ? trim($_POST['confirm']) : "";

    if ($err == "") {
        if ($username === '' ) {
            $err = "Username cannot be empty";
        }
    }

    if ($err == "") {
        if ($passwd !== $confirm) {
            $err = "The passwords do not match";
        }
    }

    $filepath = "users.csv";
    $file = null;

    if ($err == "") {
        $file = fopen($filepath, "c+");
        while (!feof($file) && $err == "") {
            $line = fgets($file);
            $line = trim($line);
            $parts = explode(':', $line, 3);
            $u = $parts[0];
            if (strtolower($u) == $username) {
                $err = "Username already in use";
            }
        }
    }

    if ($err == "" && $file !== null) {
        fseek($file, 0, SEEK_END);
        $pos = ftell($file);
        $entry = $username . ":" . $passwd . ":user";
        if ($pos > 0) {
            fwrite($file, "\n" . $entry);
        } else {
            fwrite($file, $entry);
        }
    }

    if ($file != null) {
        fclose($file);
    }

    return $err;
}

if(!isset($_POST['confirm'])){
    $type = controllaDati();
    session_start();
    setcookie("error","" , time() - 1);
    if ($type == "user") {
        $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
        $_SESSION['role'] = "user";
        header("Location:user.php");
    }
    elseif ($type == "admin") {
        $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
        $_SESSION['role'] = "admin";
        header("Location:admin.php");
    }
    else {
        setcookie("error","Username or password wrong" , time() + 3600);
        header("Location:login.php");
    }
}
else {
    $err = registerUser();
    if($err == ""){
        setcookie("error","" , time() - 3600);
        header("Location:login.php");
    }
    else{
        setcookie("error", $err , time() + 3600);
        header("Location:register.php");
    }
}
?>
