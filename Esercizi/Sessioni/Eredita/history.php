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
		$userRounds = [];

		foreach ($history as $entry) {
			if (strtolower($entry['user']) == strtolower($_SESSION['user'])) {
				$roundNum = $entry['round'];
				if (!isset($userRounds[$roundNum])) {
					$userRounds[$roundNum] = [];
				}
				$userRounds[$roundNum][] = $entry;
			}
		}

		if (empty($userRounds)) {
			echo "<p>Nessuna partita ancora registrata.</p>";
		} else {
			krsort($userRounds);

			foreach ($userRounds as $roundNum => $guesses) {
				$roundData = getRoundById($roundNum);

				if ($roundData !== false) {
					echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
					echo "<h2>Round " . $roundNum . "</h2>";
					echo "<p>Parole: " . htmlspecialchars($roundData[1]) . ", " .
						htmlspecialchars($roundData[2]) . ", " .
						htmlspecialchars($roundData[3]) . ", " .
						htmlspecialchars($roundData[4]) . ", " .
						htmlspecialchars($roundData[5]) . "</p>";
					echo "<p>Parola corretta: " . htmlspecialchars($roundData[6]) . "</p>";

					foreach ($guesses as $guess) {
						$resultText = ($guess['result'] == '1') ? ' INDOVINATO</p>' : ' SBAGLIATO</p>';
						echo "<p>Hai indovinato: " . htmlspecialchars($guess['guess']) . " - " . $resultText;
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
