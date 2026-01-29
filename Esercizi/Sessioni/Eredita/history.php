<?php
// Marchesi Pietro 5AI history.php
session_start();
require_once "readFiles.php";

if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
?>
	<!DOCTYPE html>
	<html lang="it">

	<head>
		<meta charset="UTF-8">
		<title>History</title>
	</head>

	<body>
		<h1>Storico delle Partite</h1>
		<a href="index.php"><button>Homepage</button></a>
		<a href="logout.php"><button>Logout</button></a>
		<?php
		$history = readHistory();

		if (empty($history)) {
			echo "<p>Nessuna partita ancora registrata.</p>";
		} else {
			$rounds = [];
			foreach ($history as $entry) {
				if ($entry['id'] == 'a') {
					$roundNum = $entry['round'];
					if (!isset($rounds[$roundNum])) {
						$rounds[$roundNum] = [
							'admin' => $entry,
							'guesses' => []
						];
					}
				} else {
					$roundNum = $entry['round'];
					if (isset($rounds[$roundNum])) {
						$rounds[$roundNum]['guesses'][] = $entry;
					}
				}
			}

			krsort($rounds);

			foreach ($rounds as $roundNum => $roundData) {
				$adminEntry = $roundData['admin'];
				$guessed = false;
				foreach ($roundData['guesses'] as $guess)
					if (strtolower($_SESSION['user']) == strtolower($guess['id']))
						$guessed = true;
				if ($guessed) {
					echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
					echo "<h2>Round " . $roundNum . "</h2>";
					echo "<p>Parole: " . htmlspecialchars($adminEntry['p1']) . ", " .
						htmlspecialchars($adminEntry['p2']) . ", " .
						htmlspecialchars($adminEntry['p3']) . ", " .
						htmlspecialchars($adminEntry['p4']) . ", " .
						htmlspecialchars($adminEntry['p5']) . "</p>";
					echo "<p>Parola corretta: " . htmlspecialchars($adminEntry['correct']) . "</p>";

					if (!empty($roundData['guesses'])) {
						foreach ($roundData['guesses'] as $guess) {
							if (strtolower($_SESSION['user']) == strtolower($guess['id'])) {
								$resultText = ($guess['result'] == '1') ? ' INDOVINATO</p>' : ' SBAGLIATO</p>';
								echo "<p>Hai indovinato: " . htmlspecialchars($guess['guess']) . " - " . $resultText;
							}
						}
					} else {
						echo "<p>Nessuna risposta ancora registrata per questo round.</p>";
					}
					echo "</div>";
				}
			}
		}
		?>
	</body>

	</html>

<?php
} else {
	header("Location: index.php");
}
?>
