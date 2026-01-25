<?php
session_start();
$username = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? null;
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
    <div class="container index-container">
        <h1>Word Guessing Game</h1>
        
        <?php if ($username): ?>
            <div class="welcome-section">
                <h2>Welcome back, <?= htmlspecialchars($username) ?>!</h2>
                <?php if ($role == 'admin'): ?>
                    <p class="role-badge">Administrator</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="welcome-section">
                <h2>Welcome to the Word Guessing Game</h2>
                <p>Test your vocabulary skills by guessing the hidden word!</p>
            </div>
        <?php endif; ?>

        <div class="game-section">
            <a href="game.php" class="featured-link">
                <button class="featured-button">Play the Game</button>
            </a>
        </div>

        <?php if ($username): ?>
            <div class="user-actions">
                <h3>Account Actions</h3>
                <div class="action-buttons">
                    <a href="logout.php"><button>Logout</button></a>
                    <?php if ($role == 'admin'): ?>
                        <a href="admin.php"><button>Admin Panel</button></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="auth-section">
                <h3>Get Started</h3>
                <p>Create an account or login to make guesses and track your progress</p>
                <div class="auth-buttons">
                    <a href="login.php"><button class="auth-button">Login</button></a>
                    <a href="register.php"><button class="auth-button">Register</button></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
