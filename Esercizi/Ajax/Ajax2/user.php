<?php
require_once checkUser.php
// Marchesi Pietro 5AI user.php 04/03/2025
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    $u = findUser($_SESSION['user']);
        ?>      
        <!DOCTYPE html>
        <html lang="it">
            <head>
                <meta charset="UTF-8">
                <title>Homepage</title>
            </head>
            <body>
                <h1>Homepage</h1>
                <?php 
                    $user = $_SESSION['user'];
                    echo "<p>Ciao $u</p>";
                ?>
                <a href="logout.php"><button>Logout</button></a>
            </body>
        </html>

        <?php
    }
else {
    header("Location: login.php");
}
?>
