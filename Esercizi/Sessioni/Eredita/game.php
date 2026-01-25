<?php
// Marchesi Pietro 5AI game.php
session_start();
if ($_SESSION['role'] == "admin") {
  header("Location: admin.php");
} else {
?>
  <!DOCTYPE html>
  <html lang="it">

  <head>
    <meta charset="UTF-8">
    <title>Homepage</title>
  </head>

  <body>
    <h1>Homepage</h1>
    <?php
    $user = $_SESSION['user'];
    if (file_exists("words.csv") || 0 == filesize("words.csv")) {
      $guessed = false;
      $word = "";
      $users = file("guesses.csv");
      foreach ($users as $user) {
        [$u, $w] = explode(";", trim($user), 2);
        if (strtolower($u) == strtolower($_SESSION['user'])) {
          $guessed = true;
          $word = $w;
        }
      }
      if ($guessed) {
        echo "<p>Hai già risposto con la parola $word</p>";
        $parole = file("words.csv");
        $parole = explode(";", $parole[0]);
        if (strtolower($word) == strtolower($parole[5])) {
          echo "<p>HAI INDOVINATO LA PAROLA</p>";
          echo "<a href='logout.php'><button>Logout</button></a>";
        }
      } elseif (isset($_POST['res'])) {
        echo "<p>Hai già risposto con la parola " . strtolower($_POST['res']) . "</p>";
        $file = fopen("guesses.csv", "a");
        fwrite($file, $_SESSION['user'] . ";" . strtolower($_POST['res']) . "\n");
        fclose($file);
        $parole = file("words.csv");
        $parole = explode(";", $parole[0]);
        if (strtolower($_POST['res']) == strtolower($parole[5])) {
          echo "<p>HAI INDOVINATO LA PAROLA</p>";
          echo "<a href='logout.php'><button>Logout</button></a>";
        }
      } else {
        $parole = file("words.csv");
        $parole = explode(";", $parole[0]);
        for ($i = 0; $i < 5; $i++) {
          echo "<p>Parola: $parole[$i]</p>";
        }
        if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    ?>
          <form action="" method="POST">
            <input type="text" name="res">
            <input type="submit" value="Guess">
          </form>
          <a href='logout.php'><button>Logout</button></a>
    <?php
        } else {
          echo "<p>To guess you need to <a href='login.php'>login</a></p>";
        }
      }
    } else {
      echo "<p>L'admin non ha ancora pubblicato, il gioco sara disponibile a breve</p>";
    }
    ?>
    <a href='index.php'><button>Homepage</button></a>
  </body>

  </html>

<?php
}
?>
