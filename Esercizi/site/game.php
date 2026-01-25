<?php
session_start();
require_once __DIR__ . "/includes/history.php";

$username = $_SESSION['user'] ?? null;

function getWords($filename = null)
{
  $words = null;
  $file = $filename;
  $rows = [];

  if ($file === null) {
    $file = __DIR__ . "/data/words.csv";
  }

  if (file_exists($file) && filesize($file) > 0) {
    $rows = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  }

  if (is_array($rows) && count($rows) > 0) {
    $first = trim((string)$rows[0]);
    if ($first !== '') {
      $parts = array_map('trim', explode(";", $first));
      if (count($parts) >= 6) {
        $words = $parts;
      }
    }
  }

  return $words;
}

function getUserGuess($username, $filename = null)
{
  $guess = null;
  $file = $filename;
  if ($file === null) {
    $file = __DIR__ . "/data/guesses.csv";
  }

  if ($username && file_exists($file) && filesize($file) > 0) {
    $rows = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (is_array($rows)) {
      foreach ($rows as $row) {
        $line = trim((string)$row);
        if ($line !== '') {
          $parts = explode(";", $line, 2);
          $u = $parts[0] ?? '';
          $w = $parts[1] ?? '';
          if (strtolower($u) === strtolower($username)) {
            $guess = $w;
          }
        }
      }
    }
  }

  return $guess;
}

function saveUserGuess($username, $guess, $filename = null)
{
  $check = false;
  $file = $filename;
  $u = '';
  $g = '';

  if ($file === null) {
    $file = __DIR__ . "/data/guesses.csv";
  }

  if ($username !== null) {
    $u = trim((string)$username);
    $u = str_replace(["\r", "\n", ";"], [' ', ' ', ','], $u);
    $u = trim($u);
  }

  if ($guess !== null) {
    $g = strtolower(trim((string)$guess));
    $g = str_replace(["\r", "\n", ";"], [' ', ' ', ','], $g);
    $g = trim($g);
  }

  if ($u !== '' && $g !== '') {
    $line = strtolower($u) . ";" . $g;
    $bytes = @file_put_contents($file, $line . "\n", FILE_APPEND | LOCK_EX);
    if ($bytes !== false) {
      $check = true;
    }
  }

  return $check;
}

$words = getWords();
$isPublished = $words !== null;

$previousGuess = null;
$guessResultGuess = null;
$guessResultIsCorrect = false;
$errorMessage = "";
$shouldShowForm = false;

if ($isPublished && $username) {
  $previousGuess = getUserGuess($username);
  if ($previousGuess === null) {
    $shouldShowForm = true;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['res'])) {
    $rawGuess = trim((string)($_POST['res'] ?? ''));
    if ($rawGuess !== '' && $previousGuess === null) {
      $saved = saveUserGuess($username, $rawGuess);
      if ($saved) {
        $guessResultGuess = strtolower(trim($rawGuess));
        $guessResultIsCorrect = isset($words[5]) && strtolower($guessResultGuess) === strtolower($words[5]);
        history_append_guess($username, $guessResultGuess, $words, $guessResultIsCorrect);
        $shouldShowForm = false;
      } else {
        $errorMessage = "Error saving guess. Try again.";
      }
    }
  }
}
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
<?php
echo '<div class="container game-container">';
echo '<h1>Word Guessing Game</h1>';

if (!$isPublished) {
  echo '<p>The admin has not published yet. Game will be available soon.</p>';
} else {
  echo '<h2>Words:</h2>';
  echo '<div class="words-grid">';
  for ($i = 0; $i < 5 && $i < count($words); $i++) {
    echo "<div class='word-card'>" . htmlspecialchars($words[$i]) . "</div>";
  }
  echo '</div>';

  if ($username) {
    if ($errorMessage !== "") {
      echo '<div class="error">' . htmlspecialchars($errorMessage) . '</div>';
    }

    $shownGuess = null;
    $shownIsCorrect = false;
    if ($previousGuess !== null) {
      $shownGuess = $previousGuess;
      $shownIsCorrect = isset($words[5]) && strtolower($previousGuess) === strtolower($words[5]);
    } elseif ($guessResultGuess !== null) {
      $shownGuess = $guessResultGuess;
      $shownIsCorrect = $guessResultIsCorrect;
    }

    if ($shownGuess !== null) {
      echo "<div class='guess-result'>";
      echo "<p><strong>Your guess:</strong> " . htmlspecialchars($shownGuess) . "</p>";
      if ($shownIsCorrect) {
        echo "<div class='congratulations'>CONGRATULATIONS! YOU GUESSED THE WORD</div>";
      } else {
        echo "<div class='wrong-guess'>Sorry, that's not the correct word. Try again tomorrow!</div>";
      }
      echo "</div>";
    }

    if ($shouldShowForm) {
      echo '<div class="guess-section">';
      echo '<h3>Make Your Guess</h3>';
      ?>
              <form action="" method="POST" class="guess-form">
                <input type="text" name="res" required placeholder="Your guess">
                <button type="submit">Guess</button>
              </form>
      <?php
      echo '</div>';
    }

    echo '<div class="action-links">';
    echo '<a href="storico.php"><button>History</button></a>';
    echo '<a href="logout.php"><button>Logout</button></a>';
    echo '<a href="index.php"><button>Homepage</button></a>';
    echo '</div>';
  } else {
    echo '<div class="info-message">';
    echo '<p>To make a guess, you need to <a href="login.php?redirect=game">login</a></p>';
    echo '</div>';
    echo '<div class="action-links">';
    echo '<a href="index.php"><button>Homepage</button></a>';
    echo '</div>';
  }
}

echo '</div>';
?>
</body>

</html>
