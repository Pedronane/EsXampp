<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
} else {
    if ($_SESSION['tipo'] == 1) {
        header("Location: user.php");
    } else {
        header("Location: admin.php");
    }
}
?>