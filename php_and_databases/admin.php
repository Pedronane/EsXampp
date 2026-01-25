<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
  if ($_SESSION['role'] == "user") {
    header("Location: index.php");
  } else {
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
    <div class="container admin-container">
        <div class="admin-header">
            <h1>Control Panel</h1>
            <a href="logout.php"><button style="width: auto; margin: 0;">Logout</button></a>
        </div>

<?php
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['correct'])) {
        $str = '';
        $str .= trim($_POST['p1'] ?? '');
        $str .= ';' . trim($_POST['p2'] ?? '');
        $str .= ';' . trim($_POST['p3'] ?? '');
        $str .= ';' . trim($_POST['p4'] ?? '');
        $str .= ';' . trim($_POST['p5'] ?? '');
        $str .= ';' . trim($_POST['correct'] ?? '');

        $file = fopen(__DIR__ . "/data/words.csv", "w+");
        if ($file) {
          fwrite($file, $str);
          fclose($file);
          $file = fopen(__DIR__ . "/data/guesses.csv", "w+");
          if ($file) {
            fclose($file);
          }
          $message = "Words saved successfully!";
        } else {
          $message = "Error opening file.";
        }
      }
    }

    if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

        <form action="" method="POST" class="admin-form">
            <div class="form-row">
                <input type="text" name="p1" placeholder="Word 1" value="<?= isset($_POST['p1']) ? htmlspecialchars($_POST['p1']) : '' ?>">
                <input type="text" name="p2" placeholder="Word 2" value="<?= isset($_POST['p2']) ? htmlspecialchars($_POST['p2']) : '' ?>">
                <input type="text" name="p3" placeholder="Word 3" value="<?= isset($_POST['p3']) ? htmlspecialchars($_POST['p3']) : '' ?>">
                <input type="text" name="p4" placeholder="Word 4" value="<?= isset($_POST['p4']) ? htmlspecialchars($_POST['p4']) : '' ?>">
                <input type="text" name="p5" placeholder="Word 5" value="<?= isset($_POST['p5']) ? htmlspecialchars($_POST['p5']) : '' ?>">
                <input type="text" name="correct" placeholder="Correct Answer" class="correct-word-input" value="<?= isset($_POST['correct']) ? htmlspecialchars($_POST['correct']) : '' ?>" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
  }
} else {
  header("Location: login.php");
}
?>
