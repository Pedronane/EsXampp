<?php

function checkCredentials() {
    $result = "nonuser";
    $user = $_POST['user'] ?? null;
    $passwd = $_POST['passwd'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($user !== null && $passwd !== null) {
            $data = file(__DIR__ . "/../data/users.csv");
            if (is_array($data)) {
                foreach ($data as $c) {
                    $line = trim((string)$c);
                    if ($line !== '') {
                        [$u, $p, $r] = explode(':', $line, 3);
                        if (strtolower((string)$user) == strtolower((string)$u) && (string)$passwd == (string)$p) {
                            if (trim((string)$r) == 'admin') {
                                $result = "admin";
                            } else {
                                $result = "user";
                            }
                        }
                    }
                }
            }
        }
    }
    return $result;
}

function registerUser() {
    $err = "";
    $user = $_POST['user'] ?? null;
    $passwd = $_POST['passwd'] ?? null;
    $confirm = $_POST['confirm'] ?? null;

    if ($user !== null && $passwd !== null && $confirm !== null) {
        if (trim((string)$passwd) == trim((string)$confirm)) {
            $file = fopen(__DIR__ . "/../data/users.csv", "r+");
            if ($file === false) {
                $err = "Cannot open users.csv";
            } else {
                while (!feof($file) && $err == "") {
                    $line = fgets($file);
                    if ($line) {
                        [$u, $p, $r] = explode(':', trim((string)$line), 3);
                        if ((strtolower((string)$u) == strtolower((string)$user)) && (trim((string)$r) == "user")) {
                            $err = "Username already in use";
                        }
                    }
                }

                if ($err == "") {
                    fseek($file, 0, SEEK_END);
                    fwrite($file, "\n" . strtolower((string)$user) . ":" . (string)$passwd . ":user");
                }

                fclose($file);
            }
        } else {
            $err = "The passwords do not match";
        }
    } else {
        $err = "Missing registration data";
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
