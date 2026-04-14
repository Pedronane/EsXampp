<?php
session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Playlist</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Playlist</h1> 
    <form name="frmBrani" onsubmit="return false">
        Categoria:<input type="text" name="categoria" oninput="mostraBrani(frmBrani)">
    </form>
    <div id="ris"></div>
</body>
</html>
<?php
    }
?>