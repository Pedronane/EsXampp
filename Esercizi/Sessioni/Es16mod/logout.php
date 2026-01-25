<?php
// Marchesi Pietro 5AI logout.php 11/12/2025
session_start();
session_destroy();
header("Location: login.php");
?>
