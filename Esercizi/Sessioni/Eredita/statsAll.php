<?php
// Marchesi Pietro 5AI statsAll.php
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
			<h1>All Round Stats</h1>
		<?php
		$history = readHistory();
		$rounds = getCurrentRoundId();

		if (empty($history)) {
			echo "<p>Nessuna partita ancora registrata.</p>";
		} else {
			if ($rounds) {
				$i = (int)$rounds;
				for ($i; $i > 0; $i--) {
					$roundData = getRoundById($i);
					if ($roundData) {
						echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
						echo "<h2>Round " . $i . "</h2>";
						echo "<p>Parole: " . $roundData[1] . ", " .
							$roundData[2] . ", " .
							$roundData[3] . ", " .
							$roundData[4] . ", " .
							$roundData[5] . "</p>";
						echo "<p>Parola corretta: " . $roundData[6] . "</p>";

						$total = 0;
						$won = 0;
						foreach ($history as $guess) {
							if ($i == $guess['round']) {
								$total++;
								if ($guess['result'] == '1')
									$won++;
							}
						}
						if ($total == 0) {
							echo "<p>Nessuna risposta ancora registrata per questo round.</p>";
						} else {
							$lost = $total - $won;
							echo "Guesses: $total / Won: $won / Lost: $lost";
						}
						echo "</div>";
					}
				}
			} else
				echo "Round non disponibile";
		}
	}
		?>
		<a href="logout.php"><button>Logout</button></a>
		<a href="admin.php"><button>Control Panel</button></a>
	<?php
} else {
	header("Location: login.php");
}
	?>
