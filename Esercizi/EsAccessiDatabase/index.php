<?php
session_start();
    if (!isset($_SESSION['mail'])) {
        header("Location: login.php");
    }
    else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Playlist</title>
</head>
<body>
    <a href="logout.php">Logout</a>
</body>
</html>
<?php
    }
?>