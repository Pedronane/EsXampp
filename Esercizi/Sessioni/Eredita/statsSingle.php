<?php
// Marchesi Pietro 5AI statsSingle.php
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
			<h1>Single Round Stats</h1>
		<?php
		$history = readHistory();
		$rounds = getCurrentRoundId();

		if (empty($history)) {
			echo "<p>Nessuna partita ancora registrata.</p>";
		} else {

			// Visualizza form
			echo "<h2>Seleziona un round</h2>";
			echo "<form method='get'><select name='round'>";
			for ($i = $rounds; $i > 0; $i--) {
				echo "<option value='$i'>$i</option>";
			}
			echo "<input type='submit' value='submit'>";
			echo "</select></form>";

			// Se settato GET allora visualizza il round
			if (isset($_GET['round'])) {
				$roundData = getRoundById($_GET['round']);
				if ($roundData) {
					echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
					echo "<h2>Round " . $guess['round'] . "</h2>";
					echo "<p>Parole: " . $roundData[1] . ", " .
						$roundData[2] . ", " .
						$roundData[3] . ", " .
						$roundData[4] . ", " .
						$roundData[5] . "</p>";
					echo "<p>Parola corretta: " . $roundData[6] . "</p>";

					$total = 0;
					$won = 0;
					foreach ($history as $guess) {
						if ($_GET['round'] == $guess['round']) {
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
