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
          
          // Salva le parole nel file words.csv
          if (writeWords($p1, $p2, $p3, $p4, $p5, $correct)) {
            // Inizializza la history per il nuovo round
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
      ?>

    </body>

    </html>

<?php
  }
} else {
  header("Location: login.php");
}
?>
