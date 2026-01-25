<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($_COOKIE['error'])): ?>
            <div class="error"><?= htmlspecialchars($_COOKIE['error']) ?></div>
        <?php endif; ?>
        <form method="POST" action="includes/checkUser.php">
            <?php if (isset($_GET['redirect']) && $_GET['redirect'] == 'game'): ?>
                <input type="hidden" name="redirect" value="game">
            <?php endif; ?>
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" name="user" id="user" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="passwd">Password:</label>
                <input type="password" id="passwd" name="passwd" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="link-container">
            <a href="register.php">Don't have an account? Register</a>
        </div>
        <div class="link-container">
            <a href="index.php"><button>Homepage</button></a>
        </div>
    </div>
</body>
</html>
<?php
}
?>
