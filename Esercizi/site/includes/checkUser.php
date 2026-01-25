<?php

function checkCredentials() {
    $result = "nonuser";
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {
        if (isset($_POST['user']) && isset($_POST['passwd'])) {
            $data = file(__DIR__ . "/../data/users.csv");
            foreach ($data as $c) {
                [$u, $p, $r] = explode(':', trim($c), 3);
                if (strtolower($_POST['user']) == $u && $_POST['passwd'] == $p) {
                    if (trim($r) == 'admin') {
                        $result = "admin";
                    } else {
                        $result = "user";
                    }
                }
            }
        }
    }
    return $result;
}

function registerUser() {
    $err = "";
    if (trim($_POST['passwd']) == trim($_POST['confirm'])) {
        $file = fopen(__DIR__ . "/../data/users.csv", "r+");
        if ($file === false) {
            return "Cannot open users.csv";
        }

        while (!feof($file) && $err == "") {
            $line = fgets($file);
            if ($line) {
                [$u, $p, $r] = explode(':', trim($line), 3);
                if ((strtolower($u) == strtolower($_POST['user'])) && ($r == "user")) {
                    $err = "Username already in use";
                }
            }
        }

        if ($err == "") {
            fseek($file, 0, SEEK_END);
            fwrite($file, "\n" . strtolower($_POST['user']) . ":" . $_POST['passwd'] . ":user");
        }

        fclose($file);
    } else {
        $err = "The passwords do not match";
    }
    return $err;
}

if (!isset($_POST['confirm'])) {
    $type = checkCredentials();
    session_start();
    setcookie("error", "", time() - 1);
    $redirect = $_POST['redirect'] ?? null;
    if ($type == "user") {
        $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
        $_SESSION['role'] = "user";
        if ($redirect == "game") {
            header("Location: ../game.php");
        } else {
            header("Location: ../index.php");
        }
    } elseif ($type == "admin") {
        $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
        $_SESSION['role'] = "admin";
        header("Location: ../admin.php");
    } else {
        setcookie("error", "Username or password wrong", time() + 3600);
        $redirectParam = $redirect ? "?redirect=" . $redirect : "";
        header("Location: ../login.php" . $redirectParam);
    }
} else {
    $err = registerUser();
    if ($err == "") {
        setcookie("error", "", time() - 3600);
        header("Location: ../login.php");
    } else {
        setcookie("error", $err, time() + 3600);
        header("Location: ../register.php");
    }
}
