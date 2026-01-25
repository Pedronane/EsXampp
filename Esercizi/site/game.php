<?php
session_start();

$username = $_SESSION['user'] ?? null;

function getWords($filename = __DIR__ . "/data/words.csv")
{
	$words = null;
  if (file_exists($filename) && filesize($filename) > 0) {
  	$rows = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  }
  if (!empty($rows)) {
    $words = null;
  }
  return explode(";", $rows[0]);
}

function getUserGuess($username, $filename = __DIR__ . "/data/guesses.csv")
{
  if (!$username || !file_exists($filename) || filesize($filename) == 0) {
    return null;
  }
  $rows = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($rows as $row) {
    if (trim($row)) {
      [$u, $w] = explode(";", trim($row), 2);
      if (strtolower($u) === strtolower($username)) {
        return $w;
      }
    }
  }
  return null;
}

function saveUserGuess($username, $guess, $filename = __DIR__ . "/data/guesses.csv")
{
	$check = false;
  $f = fopen($filename, "a");
  if ($f) {
    fwrite($f, $username . ";" . strtolower($guess) . "\n");
    fclose($f);
    $check = true;
  }
  return $check;
}

$words = getWords();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Word Guessing Game</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/game.css">
</head>

<body>
  <div class="container game-container">
    <h1>Word Guessing Game</h1>

    <?php if ($words === null)
      echo "<p>The admin has not published yet. Game will be available soon.</p>";
    else {
    ?>
      <h2>Words:</h2>
      <div class="words-grid">
        <?php for ($i = 0; $i < 5 && $i < count($words); $i++)
          echo "<div class='word-card'>" . htmlspecialchars($words[$i]) . "</div>";
        echo "</div>";

        if ($username) {
          $previousGuess = getUserGuess($username);

          if ($previousGuess !== null) {
            echo "<div class='guess-result'>";
            echo "<p><strong>Your guess:</strong>" . htmlspecialchars($previousGuess) . "</p>";
            if (isset($words[5]) && strtolower($previousGuess) === strtolower($words[5]))
              echo "<div class='congratulations'>CONGRATULATIONS! YOU GUESSED THE WORD</div>";
            else
              echo "<div class='wrong-guess'>Sorry, that's not the correct word. Try again tomorrow!</div>";
            echo "</div>";
          } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['res']) && $_POST['res'] !== "") {
            $guess = trim($_POST['res']);
            if (saveUserGuess($username, $guess)) {
              echo '<div class="guess-result">';
              echo '<p><strong>Your guess:</strong> ' . htmlspecialchars(strtolower($guess)) . '</p>';
              if (isset($words[5]) && strtolower($guess) === strtolower($words[5])):
                echo '<div class="congratulations">CONGRATULATIONS! YOU GUESSED THE WORD</div>';
              else:
                echo '<div class="wrong-guess">Sorry, that\'s not the correct word. Try again tomorrow!</div>';
              endif;
              echo '</div>';
            } else
              echo '<div class="error">Error saving guess. Try again.</div>';
          } else {
        ?>
            <div class="guess-section">
              <h3>Make Your Guess</h3>
              <form action="" method="POST" class="guess-form">
                <input type="text" name="res" required placeholder="Your guess">
                <button type="submit">Guess</button>
              </form>
            </div>
          <?php
          }
          ?>
          <div class="action-links">
            <a href="logout.php"><button>Logout</button></a>
            <a href="index.php"><button>Homepage</button></a>
          </div>
        <?php
        } else {
        ?>
          <div class="info-message">
            <p>To make a guess, you need to <a href="login.php?redirect=game">login</a></p>
          </div>
          <div class="action-links">
            <a href="index.php"><button>Homepage</button></a>
          </div>
        <?php
        }
        ?>

      <?php } ?>
      </div>
</body>

</html>
