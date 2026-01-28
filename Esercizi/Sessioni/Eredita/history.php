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
			// Raggruppa per round
			$rounds = [];
			foreach ($history as $entry) {
				if ($entry['id'] == 'a') {
					// Entry admin - definisce un nuovo round
					$roundNum = $entry['round'];
					if (!isset($rounds[$roundNum])) {
						$rounds[$roundNum] = [
							'admin' => $entry,
							'guesses' => []
						];
					}
				} else {
					// Entry utente - aggiungi al round corrispondente
					$roundNum = $entry['round'];
					if (isset($rounds[$roundNum])) {
						$rounds[$roundNum]['guesses'][] = $entry;
					}
				}
			}

			// Ordina i round in ordine decrescente (più recenti prima)
			krsort($rounds);

			foreach ($rounds as $roundNum => $roundData) {
				$adminEntry = $roundData['admin'];
				echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
				echo "<h2>Round " . $roundNum . "</h2>";
				echo "<p><strong>Parole:</strong> " . htmlspecialchars($adminEntry['p1']) . ", " .
					htmlspecialchars($adminEntry['p2']) . ", " .
					htmlspecialchars($adminEntry['p3']) . ", " .
					htmlspecialchars($adminEntry['p4']) . ", " .
					htmlspecialchars($adminEntry['p5']) . "</p>";
				echo "<p><strong>Parola corretta:</strong> " . htmlspecialchars($adminEntry['correct']) . "</p>";

				if (!empty($roundData['guesses'])) {
					echo "<h3>Risposta data:</h3>";
					echo "<ul>";
					foreach ($roundData['guesses'] as $guess) {
						if (strtolower($_SESSION['user']) == strtolower($guess['id'])) {
							$resultText = ($guess['result'] == '1') ? 'INDOVINATO' : '<p style="color: red;">SBAGLIATO</p>';
							echo "ha indovinato: " . htmlspecialchars($guess['guess']) . " - " . $resultText;
						}
					}
					echo "</ul>";
				} else {
					echo "<p>Nessuna risposta ancora registrata per questo round.</p>";
				}
				echo "</div>";
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
