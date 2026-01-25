<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($))
?>
<!DOCTYPE html>
<html>
<head>
    <title>Coda dal medico</title>
</head>
<body>
    <h1>Gestione coda</h1>
    <form>
        <input type="text" name="nome"><br><br>
        <input type="submit" name="add" value="Aggiungi in coda"><br>

        <input type="submit" name="rem" value="Rimuovi il primo dalla coda"><br>
        <input type="submit" name="clear" value="Svuota completamente la coda">
    </form>
    <br>
</body>
</html>