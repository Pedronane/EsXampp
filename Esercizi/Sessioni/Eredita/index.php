<?php
// Marchesi Pietro 5AI index.php
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="UTF-8">
	<title>Sito</title>
</head>

<body>
	<h1>Sito</h1>
	<?php
	if (isset($_SESSION['user'])) {
		echo "<a href='logout.php'><button>Logout</button></a>";
		echo "<a href='history.php'><button>History</button></a>";
	} else {
	?>
		<a href="login.php"><button>Accedi</button></a>
		<a href="register.php"><button>Registrati</button></a>
	<?php
	}
	?>
	<br>
	<a href="game.php"><button>Gioca all'eredita</button></a>
</body>

</html>
