<?php
// Marchesi Pietro 5AI admin.php
session_start();
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
        if (isset($_POST['correct'])) {
          $str = '';
					$guesses = file("history.csv");
					$id = array_pop($guesses);
					$id = explode(";", $id);
					if($id[0] == "a")
						$str = "a" . ";" . $id[1]+1 . ";";
					$str = "a" . ";" . $id[0]+1 . ";";
          $str .= ';' . trim($_POST['p2'] ?? '');
          $str .= ';' . trim($_POST['p3'] ?? '');
          $str .= ';' . trim($_POST['p4'] ?? '');
          $str .= ';' . trim($_POST['p5'] ?? '');
          $str .= ';' . trim($_POST['correct'] ?? '');

          $file = fopen("history.csv", "w+");
          if ($file) {
           	fwrite($file, $str);
            fclose($file);
            $file = fopen("guesses.csv", "w+");
          } else {
            echo "Errore apertura file.";
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
