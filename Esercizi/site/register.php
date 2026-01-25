<?php
session_start();
$isLogged = isset($_SESSION['user']) && isset($_SESSION['role']);
$role = $_SESSION['role'] ?? null;
$shouldRender = !$isLogged;

if ($isLogged) {
    if ($role == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
    $shouldRender = false;
}

$errorCookie = $_COOKIE['error'] ?? '';
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
<?php
if ($shouldRender) {
    echo '<div class="container">';
    echo '<h1>Register</h1>';
    if (trim((string)$errorCookie) !== '') {
        echo '<div class="error">' . htmlspecialchars($errorCookie) . '</div>';
    }
?>
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
<?php
    echo '<div class="link-container">';
    echo '<a href="login.php">Already have an account? Login</a>';
    echo '</div>';
    echo '<div class="link-container">';
    echo '<a href="index.php"><button>Homepage</button></a>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="container">';
    echo '<p>Redirecting...</p>';
    echo '</div>';
}
?>
</body>
</html>
