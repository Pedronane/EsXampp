<?php
// Marchesi Pietro 5AI logout.php
session_start();
session_destroy();
header("Location: index.php");
