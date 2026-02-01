<?php
// Marchesi Pietro 5AI admin.php
session_start();
require_once "readFiles.php";
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "user") {
		header("Location: index.php");
	} else {
?>
		<!DOCTYPE html>
		<html lang="it">

		<head>
			<meta charset="UTF-8">
			<title>Control Panel</title>
		</head>

		<body>
			<h1>Control Panel</h1>
			<a href="addRound.php"><button>Aggiungi round</button></a>
			<a href="statsSingle.php"><button>Single round stats</button></a>
			<a href="statsAll.php"><button>All rounds stats</button></a>
			<a href="logout.php"><button>Logout</button></a>
		</body>

		</html>

<?php
	}
} else {
	header("Location: login.php");
}
?>
