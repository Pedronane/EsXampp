<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: index.php");
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
                echo "<p>$error</p>";
            }
        ?>
        <br>
        <a href="logout.php">log out</a>
    </body>
</html>
<?php
    }
?>
