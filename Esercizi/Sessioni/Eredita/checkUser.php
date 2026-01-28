<?php
// Marchesi Pietro 5AI checkUser.php
require_once "readFiles.php";

function controllaDati()
{
  $result = "nonuser";
  if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {
    if (isset($_POST['user']) && isset($_POST['passwd'])) {
      $role = checkCredentials($_POST['user'], $_POST['passwd']);
      if ($role !== false) {
        $result = $role;
      }
    }
  }
  return $result;
}

// Si ipotizza che solo un user possa eseguire la registrazione
// Un admin può inserire le proprie credenziali direttamente in file
function registerUserLocal()
{
  $err = "";
  if (trim($_POST['passwd']) == trim($_POST['confirm'])) {
    if (usernameExists($_POST['user'])) {
      $err = "Username already in use";
    } else {
      if (!registerUser($_POST['user'], $_POST['passwd'])) {
        $err = "Cannot register user";
      }
    }
  } else {
    $err = "The passwords do not match";
  }
  return $err;
}

if (!isset($_POST['confirm'])) {
  $type = controllaDati();
  session_start();
  setcookie("error", "", time() - 1);
  if ($type == "user") {
    $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
    $_SESSION['role'] = "user";
    header("Location:index.php");
  } elseif ($type == "admin") {
    $_SESSION['user'] = ucfirst(strtolower($_POST['user']));
    $_SESSION['role'] = "admin";
    header("Location:admin.php");
  } else {
    setcookie("error", "Username or password wrong", time() + 3600);
    header("Location:login.php");
  }
} else {
  $err = registerUserLocal();
  if ($err == "") {
    setcookie("error", "", time() - 3600);
    header("Location:login.php");
  } else {
    setcookie("error", $err, time() + 3600);
    header("Location:register.php");
  }
}
