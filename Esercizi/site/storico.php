<?php
session_start();
require_once __DIR__ . "/includes/history.php";

$username = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? null;
$isLogged = $username !== null && $role !== null;
$isAdmin = $isLogged && $role === 'admin';

$events = history_read_events();
$games = [];
$guesses = [];

if (is_array($events)) {
  foreach ($events as $ev) {
    if (($ev['type'] ?? '') === 'GAME') {
      $games[] = $ev;
    } elseif (($ev['type'] ?? '') === 'GUESS') {
      $guesses[] = $ev;
    }
  }
}

if ($isLogged && !$isAdmin) {
  $filtered = [];
  foreach ($guesses as $g) {
    $u = $g['user'] ?? '';
    if (strtolower($u) === strtolower((string)$username)) {
      $filtered[] = $g;
    }
  }
  $guesses = $filtered;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/storico.css">
</head>
<body>
<?php
echo '<div class="container history-container">';
echo '<h1>History</h1>';

if (!$isLogged) {
  echo '<div class="info-message">';
  echo '<p>To view the history you need to <a href="login.php">login</a>.</p>';
  echo '</div>';
} else {
  if ($isAdmin) {
    echo '<h2>Published games</h2>';
    if (count($games) === 0) {
      echo '<p>No games published yet.</p>';
    } else {
      echo '<div class="table-wrap"><table class="history-table">';
      echo '<thead><tr><th>Date</th><th>Words</th><th>Winning word</th></tr></thead><tbody>';
      foreach (array_reverse($games) as $g) {
        $ts = htmlspecialchars($g['ts'] ?? '');
        $words = $g['words'] ?? [];
        $wordsText = htmlspecialchars(implode(', ', $words));
        $correct = htmlspecialchars($g['correct'] ?? '');
        echo '<tr>';
        echo '<td class="col-ts">' . $ts . '</td>';
        echo '<td>' . $wordsText . '</td>';
        echo '<td class="col-correct">' . $correct . '</td>';
        echo '</tr>';
      }
      echo '</tbody></table></div>';
    }

    echo '<h2>User guesses</h2>';
    if (count($guesses) === 0) {
      echo '<p>No guesses recorded yet.</p>';
    } else {
      echo '<div class="table-wrap"><table class="history-table">';
      echo '<thead><tr><th>Date</th><th>User</th><th>Guess</th><th>Words</th><th>Winning word</th><th>Result</th></tr></thead><tbody>';
      foreach (array_reverse($guesses) as $g) {
        $ts = htmlspecialchars($g['ts'] ?? '');
        $user = htmlspecialchars($g['user'] ?? '');
        $guess = htmlspecialchars($g['guess'] ?? '');
        $words = $g['words'] ?? [];
        $wordsText = htmlspecialchars(implode(', ', $words));
        $correct = htmlspecialchars($g['correct'] ?? '');
        $res = ($g['isCorrect'] ?? false) ? 'WIN' : 'LOSE';
        $resClass = ($g['isCorrect'] ?? false) ? 'res-win' : 'res-lose';
        echo '<tr>';
        echo '<td class="col-ts">' . $ts . '</td>';
        echo '<td>' . $user . '</td>';
        echo '<td>' . $guess . '</td>';
        echo '<td>' . $wordsText . '</td>';
        echo '<td class="col-correct">' . $correct . '</td>';
        echo '<td class="' . $resClass . '">' . $res . '</td>';
        echo '</tr>';
      }
      echo '</tbody></table></div>';
    }
  } else {
    echo '<h2>Your played games</h2>';
    if (count($guesses) === 0) {
      echo '<p>No games played yet.</p>';
    } else {
      echo '<div class="table-wrap"><table class="history-table">';
      echo '<thead><tr><th>Date</th><th>Your guess</th><th>Words</th><th>Winning word</th><th>Result</th></tr></thead><tbody>';
      foreach (array_reverse($guesses) as $g) {
        $ts = htmlspecialchars($g['ts'] ?? '');
        $guess = htmlspecialchars($g['guess'] ?? '');
        $words = $g['words'] ?? [];
        $wordsText = htmlspecialchars(implode(', ', $words));
        $correct = htmlspecialchars($g['correct'] ?? '');
        $res = ($g['isCorrect'] ?? false) ? 'WIN' : 'LOSE';
        $resClass = ($g['isCorrect'] ?? false) ? 'res-win' : 'res-lose';
        echo '<tr>';
        echo '<td class="col-ts">' . $ts . '</td>';
        echo '<td>' . $guess . '</td>';
        echo '<td>' . $wordsText . '</td>';
        echo '<td class="col-correct">' . $correct . '</td>';
        echo '<td class="' . $resClass . '">' . $res . '</td>';
        echo '</tr>';
      }
      echo '</tbody></table></div>';
    }
  }
}

echo '<div class="action-links">';
echo '<a href="game.php"><button>Play</button></a>';
echo '<a href="index.php"><button>Homepage</button></a>';
echo '</div>';
echo '</div>';
?>
</body>
</html>
