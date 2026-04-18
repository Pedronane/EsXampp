<?php
require_once "conDB.php";
session_start();
// fai query per aggiornare accessi
session_destroy();
header("Location: login.php");
?>