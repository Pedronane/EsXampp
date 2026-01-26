<?php
// Marchesi Pietro 5AI history.php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
?>
    <!DOCTYPE html>
    <html lang="it">

    <head>
      <meta charset="UTF-8">
      <title>Control Panel</title>
    </head>

    <body>
			if (file_exists("history.csv") || 0 == filesize("history.csv")) {
				$history = file("history.csv");
				foreach($history as $line){
					[$id, $p1, $p2, $p3, $p4, $p5, $cor, $guess, $res] = explode(";", $line);
					if($id != "a"){
						echo "<p> $p1, $p2, $p3, $p4, $p5 corretta: $cor indovinata: $guess</p>";
					}
				}
			}
    </body>

    </html>

<?php
  }
 	else {
  	header("Location: index.php");
}
?>
