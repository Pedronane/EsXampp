<?php
// Marchesi Pietro 5AI addRound.php
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
			<form action="" method="POST">
				<input type="text" name="p1" placeholder="Parola1">
				<input type="text" name="p2" placeholder="Parola2">
				<input type="text" name="p3" placeholder="Parola3">
				<input type="text" name="p4" placeholder="Parola4">
				<input type="text" name="p5" placeholder="Parola5"><br>
				<input type="text" name="correct" placeholder="Correct"><br>
				<input type="submit" value="Submit">
			</form>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (isset($_POST['correct']) && isset($_POST['p1'])) {
					$p1 = trim($_POST['p1'] ?? '');
					$p2 = trim($_POST['p2'] ?? '');
					$p3 = trim($_POST['p3'] ?? '');
					$p4 = trim($_POST['p4'] ?? '');
					$p5 = trim($_POST['p5'] ?? '');
					$correct = trim($_POST['correct'] ?? '');

					if (!writeWords($p1, $p2, $p3, $p4, $p5, $correct)) {
						echo "<p>Errore nella scrittura delle parole.</p>";
					}
				}
			}
			?>
			<a href="logout.php"><button>Logout</button></a>
			<a href="admin.php"><button>Control Panel</button></a>

		</body>

		</html>

<?php
	}
} else {
	header("Location: login.php");
}
?>
