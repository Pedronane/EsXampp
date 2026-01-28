<?php
// Marchesi Pietro 5AI game.php
session_start();
require_once "readFiles.php";

if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
	header("Location: admin.php");
} else {
?>
	<!DOCTYPE html>
	<html lang="it">

	<head>
		<meta charset="UTF-8">
		<title>Homepage</title>
	</head>

	<body>
		<h1>Homepage</h1>
		<?php
		$words = readWords();
		if ($words !== false) {
			$currentRound = getCurrentRoundId();
			$userGuess = getUserGuessForRound($_SESSION['user'], $currentRound);

			if ($userGuess !== false) {
				echo "<p>Hai già risposto con la parola $userGuess</p>";
				if (strtolower($userGuess) == strtolower($words['correct'])) {
					echo "<p>HAI INDOVINATO LA PAROLA</p>";
					echo "<a href='logout.php'><button>Logout</button></a>";
				}
			} elseif (isset($_POST['res'])) {
				$guess = strtolower(trim($_POST['res']));
				echo "<p>Hai già risposto con la parola $guess</p>";

				$hasGuessed = (strtolower($guess) == strtolower($words['correct']));
				if ($hasGuessed) {
					echo "<p>HAI INDOVINATO LA PAROLA</p>";
					echo "<a href='logout.php'><button>Logout</button></a>";
				}

				addGuessToHistory($_SESSION['user'], $guess, $hasGuessed);
			} else {
				echo "<p>Parola: " . $words['p1'] . "</p>";
				echo "<p>Parola: " . $words['p2'] . "</p>";
				echo "<p>Parola: " . $words['p3'] . "</p>";
				echo "<p>Parola: " . $words['p4'] . "</p>";
				echo "<p>Parola: " . $words['p5'] . "</p>";

				if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
		?>
					<form action="" method="POST">
						<input type="text" name="res">
						<input type="submit" value="Guess">
					</form>
					<a href='logout.php'><button>Logout</button></a>
		<?php
				} else {
					echo "<p>To guess you need to <a href='login.php'>login</a></p>";
				}
			}
		} else {
			echo "<p>L'admin non ha ancora pubblicato, il gioco sara disponibile a breve</p>";
		}
		?>
		<a href='index.php'><button>Homepage</button></a>
	</body>

	</html>
<?php
}
?>
