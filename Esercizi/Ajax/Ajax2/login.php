<?php
    // Marchesi Pietro 5AI login.php 04/03/2025
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: user.php");
    }
    else {
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <script srch="script.js"></script>
    </head>
    <body>
        <h1>Login</h1>
        <div id="err"></div>
        <form method="POST" action="checkUser.php" onsubmit="this">
            <label for="user">Username: </label>
            <input type="text" name="user" id="user" placeholder="Username">
            <br>
            <label for="passwd">Password: </label>
            <input type="password" id="passwd" name="passwd" placeholder="Password">
            <br>
            <input type="submit" value="Accedi">
        </form>
        <br>
    </body>
</html>
<?php
    }
?>
