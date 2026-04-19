<?php
session_start();
if(!isset($_SESSION['user']))
    header("location: login.php");
else{
?>
    <html lang="en">
    <head>
        <title>homepage</title>
    </head>
    <body>
        <h1>Benvenuto</h1>
        <a href="visPlaylist.php"><button>Visualizza playlist</button></a>
        <a href="cercaCategoria.php"><button>Cerca per categoria</button></a>
    </body>
    </html>
<?php
}
?>