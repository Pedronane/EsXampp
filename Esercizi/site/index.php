<?php
session_start();
$username = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? null;
$isLogged = $username !== null;
$isAdmin = $role === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Word Guessing Game</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<?php
echo '<div class="container index-container">';
echo '<h1>Word Guessing Game</h1>';

if ($isLogged) {
  echo '<div class="welcome-section">';
  echo '<h2>Welcome back, ' . htmlspecialchars($username) . '!</h2>';
  if ($isAdmin) {
    echo '<p class="role-badge">Administrator</p>';
  }
  echo '</div>';
} else {
  echo '<div class="welcome-section">';
  echo '<h2>Welcome to the Word Guessing Game</h2>';
  echo '<p>Test your vocabulary skills by guessing the hidden word!</p>';
  echo '</div>';
}

echo '<div class="game-section">';
echo '<a href="game.php" class="featured-link">';
echo '<button class="featured-button">Play the Game</button>';
echo '</a>';
echo '</div>';

if ($isLogged) {
  echo '<div class="user-actions">';
  echo '<h3>Account Actions</h3>';
  echo '<div class="action-buttons">';
  echo '<a href="storico.php"><button>History</button></a>';
  echo '<a href="logout.php"><button>Logout</button></a>';
  if ($isAdmin) {
    echo '<a href="admin.php"><button>Admin Panel</button></a>';
  }
  echo '</div>';
  echo '</div>';
} else {
  echo '<div class="auth-section">';
  echo '<h3>Get Started</h3>';
  echo '<p>Create an account or login to make guesses and track your progress</p>';
  echo '<div class="auth-buttons">';
  echo '<a href="login.php"><button class="auth-button">Login</button></a>';
  echo '<a href="register.php"><button class="auth-button">Register</button></a>';
  echo '</div>';
  echo '</div>';
}

echo '</div>';
?>
</body>
</html>
