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
			<a href="logout.php"><button>Logout</button></a>
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

					if (writeWords($p1, $p2, $p3, $p4, $p5, $correct)) {
						if (initHistory($p1, $p2, $p3, $p4, $p5, $correct)) {
							echo "<p>Parole pubblicate con successo!</p>";
						} else {
							echo "<p>Errore nell'inizializzazione della history.</p>";
						}
					} else {
						echo "<p>Errore nella scrittura delle parole.</p>";
					}
				}
			}
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

				// Visualizza form
				echo "<h2>Seleziona un round</h2>";
				echo "<form method='get'><select name='round'>";
				foreach ($rounds as $roundNum => $roundData) {
					echo "<option value='$roundNum'>$roundNum</option>";
				}
				echo "<input type='submit' value='submit'>";
				echo "</select></form>";

				// Se settato GET allora visualizza il round
				if (isset($_GET['round'])) {
					foreach ($rounds as $roundNum => $roundData) {
						if ((int)$_GET['round'] == $roundNum) {
							$adminEntry = $roundData['admin'];
							echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
							echo "<h2>Round " . $roundNum . "</h2>";
							echo "<p>Parole: " . htmlspecialchars($adminEntry['p1']) . ", " .
								htmlspecialchars($adminEntry['p2']) . ", " .
								htmlspecialchars($adminEntry['p3']) . ", " .
								htmlspecialchars($adminEntry['p4']) . ", " .
								htmlspecialchars($adminEntry['p5']) . "</p>";
							echo "<p>Parola corretta: " . htmlspecialchars($adminEntry['correct']) . "</p>";

							if (!empty($roundData['guesses'])) {
								$total = 0;
								$won = 0;
								foreach ($roundData['guesses'] as $guess) {
									$total++;
									if ($guess['result'] == '1')
										$won++;
								}
								$lost = $total - $won;
								echo "Guesses: $total / Won: $won / Lost: $lost";
							} else {
								echo "<p>Nessuna risposta ancora registrata per questo round.</p>";
							}
							echo "</div>";
						}
					}
				}

				foreach ($rounds as $roundNum => $roundData) {
					$adminEntry = $roundData['admin'];
					echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
					echo "<h2>Round " . $roundNum . "</h2>";
					echo "<p>Parole: " . htmlspecialchars($adminEntry['p1']) . ", " .
						htmlspecialchars($adminEntry['p2']) . ", " .
						htmlspecialchars($adminEntry['p3']) . ", " .
						htmlspecialchars($adminEntry['p4']) . ", " .
						htmlspecialchars($adminEntry['p5']) . "</p>";
					echo "<p>Parola corretta: " . htmlspecialchars($adminEntry['correct']) . "</p>";

					if (!empty($roundData['guesses'])) {
						$total = 0;
						$won = 0;
						foreach ($roundData['guesses'] as $guess) {
							$total++;
							if ($guess['result'] == '1')
								$won++;
						}
						$lost = $total - $won;
						echo "Guesses: $total / Won: $won / Lost: $lost";
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
	}
} else {
	header("Location: login.php");
}
?>
