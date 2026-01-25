<?php
// Marchesi Pietro 5AI checkUser.php 11/12/2025
function controllaDati() {
    $result = "nonuser";
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){
        if (isset($_POST['user']) && isset($_POST['passwd'])) {
            $data = file("users.csv");
            foreach($data as $c){
                [$u, $p, $r] = explode(':', trim($c), 3);
                if (strtolower($_POST['user']) == $u && $_POST['passwd'] == $p) {
                    if(trim($r) == 'admin'){
                        $result = "admin";        
                    }
                    else {
                        $result = "user";
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
    if (trim($_POST['passwd']) == trim($_POST['confirm'])) {
        $file = fopen("users.csv","r+");
        if ($file === false) {
            return "Cannot open users.csv";
        }

        while (!feof($file) && $err == "") {
            $line = fgets($file);
            [$u, $p, $r] = explode(':', trim($line), 3);
            if ((strtolower($u) == strtolower($_POST['user'])) && ($r == "user")) {
                $err = "Username already in use";
            }
        }

        if ($err == "") {
            fseek($file, 0, SEEK_END);
            fwrite($file, strtolower($_POST['user']).":".$_POST['passwd'].":user");
        }

        fclose($file);
    }
    else {
        $err = "The passwords do not match";
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
