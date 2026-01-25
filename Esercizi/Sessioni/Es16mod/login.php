<?php
    // Marchesi Pietro 5AI login.php 11/12/2025
    session_start();
    if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
        if ($_SESSION['role'] == "admin") {
            header("Location: admin.php");
        }
        else {
            header("Location: user.php");
        }
    }
    else {
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form method="POST" action="checkUser.php">
            <label for="user">Username: </label>
            <input type="text" name="user" id="user" placeholder="Username">
            <br>
            <label for="passwd">Password: </label>
            <input type="password" id="passwd" name="passwd" placeholder="Password">
            <br>
            <input type="submit" value="Accedi">
        </form>
        <?php 
            if (isset($_COOKIE['error'])) {
                $error = $_COOKIE['error'];
                echo "<h1>$error</h1>";
            }
        ?>
        <br>
        <a href="register.php">Registrati</a>
    </body>
</html>
<?php
    }
?>
