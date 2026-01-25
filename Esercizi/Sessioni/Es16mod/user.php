<?php
// Marchesi Pietro 5AI user.php 11/12/2025
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == "admin") {
        header("Location: admin.php");
    }
    else {
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
                    echo "<p>Ciao $user</p>";
                ?>
                <a href="logout.php"><button>Logout</button></a>
            </body>
        </html>

        <?php
    }
}
else {
    header("Location: login.php");
}
?>
