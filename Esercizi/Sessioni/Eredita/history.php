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
			
    </body>

    </html>

<?php
  }
} else {
  header("Location: index.php");
}
?>
