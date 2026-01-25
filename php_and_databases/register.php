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
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($_COOKIE['error'])): ?>
            <div class="error"><?= htmlspecialchars($_COOKIE['error']) ?></div>
        <?php endif; ?>
        <form method="POST" action="includes/checkUser.php">
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" name="user" id="user" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="passwd">Password:</label>
                <input type="password" id="passwd" name="passwd" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password:</label>
                <input type="password" id="confirm" name="confirm" placeholder="Confirm password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="link-container">
            <a href="login.php">Already have an account? Login</a>
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
