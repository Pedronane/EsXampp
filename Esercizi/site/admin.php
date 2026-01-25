<?php
session_start();
require_once __DIR__ . "/includes/history.php";

$isLogged = isset($_SESSION['user']) && isset($_SESSION['role']);
$isAdmin = $isLogged && $_SESSION['role'] === "admin";
$shouldRender = $isAdmin;
$message = "";

if (!$isLogged) {
  header("Location: login.php");
  $shouldRender = false;
} elseif (!$isAdmin) {
  header("Location: index.php");
  $shouldRender = false;
}

if ($shouldRender) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['correct'])) {
      $p1 = trim($_POST['p1'] ?? '');
      $p2 = trim($_POST['p2'] ?? '');
      $p3 = trim($_POST['p3'] ?? '');
      $p4 = trim($_POST['p4'] ?? '');
      $p5 = trim($_POST['p5'] ?? '');
      $correct = trim($_POST['correct'] ?? '');
      $p1 = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $p1));
      $p2 = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $p2));
      $p3 = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $p3));
      $p4 = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $p4));
      $p5 = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $p5));
      $correct = trim(str_replace(["\r", "\n", ";"], [' ', ' ', ','], $correct));

      $str = '';
      $str .= $p1;
      $str .= ';' . $p2;
      $str .= ';' . $p3;
      $str .= ';' . $p4;
      $str .= ';' . $p5;
      $str .= ';' . $correct;

      $file = fopen(__DIR__ . "/data/words.csv", "w+");
      if ($file) {
        fwrite($file, $str);
        fclose($file);

        $file = fopen(__DIR__ . "/data/guesses.csv", "w+");
        if ($file) {
          fclose($file);
        }

        history_append_game($_SESSION['user'], [$p1, $p2, $p3, $p4, $p5, $correct]);
        $message = "Words saved successfully!";
      } else {
        $message = "Error opening file.";
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
    <title>Control Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<?php
if ($shouldRender) {
  echo '<div class="container admin-container">';
  echo '<div class="admin-header">';
  echo '<h1>Control Panel</h1>';
  echo '<a href="logout.php"><button style="width: auto; margin: 0;">Logout</button></a>';
  echo '</div>';

  if ($message !== "") {
    echo '<div class="message">' . htmlspecialchars($message) . '</div>';
  }
}
?>

<?php if ($shouldRender) { ?>
        <form action="" method="POST" class="admin-form">
            <div class="form-row">
                <input type="text" name="p1" placeholder="Word 1" value="<?php echo isset($_POST['p1']) ? htmlspecialchars($_POST['p1']) : ''; ?>">
                <input type="text" name="p2" placeholder="Word 2" value="<?php echo isset($_POST['p2']) ? htmlspecialchars($_POST['p2']) : ''; ?>">
                <input type="text" name="p3" placeholder="Word 3" value="<?php echo isset($_POST['p3']) ? htmlspecialchars($_POST['p3']) : ''; ?>">
                <input type="text" name="p4" placeholder="Word 4" value="<?php echo isset($_POST['p4']) ? htmlspecialchars($_POST['p4']) : ''; ?>">
                <input type="text" name="p5" placeholder="Word 5" value="<?php echo isset($_POST['p5']) ? htmlspecialchars($_POST['p5']) : ''; ?>">
                <input type="text" name="correct" placeholder="Correct Answer" class="correct-word-input" value="<?php echo isset($_POST['correct']) ? htmlspecialchars($_POST['correct']) : ''; ?>" required>
            </div>
            <button type="submit">Submit</button>
        </form>
<?php } ?>
<?php
if ($shouldRender) {
  echo '</div>';
} else {
  echo '<div class="container admin-container">';
  echo '<p>Redirecting...</p>';
  echo '</div>';
}
?>
</body>
</html>
