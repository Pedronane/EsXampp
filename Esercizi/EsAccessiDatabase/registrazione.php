<?php
session_start();
if(isset($_SESSION['userId']))
    header("location: index.php");
else{
?>
<html lang="it">
<head>
    <title>Registrazione</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Registrazione</h1>
    <form name="frmReg" onsubmit="registraUser(this); return false;">
        <input type="text" name="nome" placeholder="Nome" required>
        <br>
        <input type="text" name="cognome" placeholder="Cognome" required>
        <br>
        <input type="email" name="email" placeholder="Email" required>
        <br>
        <input type="date" name="dataNascita" required>
        <br>
        <select name="sesso" required>
            <option value="">Seleziona sesso</option>
            <option value="M">Maschio</option>
            <option value="F">Femmina</option>
        </select>
        <br>
        <input type="password" name="password" placeholder="Password (min 8 caratteri)" required>
        <br>
        <input type="password" name="confermaPassword" placeholder="Conferma Password" required>
        <br>
        <input type="tel" name="telefono" placeholder="Telefono" required>
        <br>
        <input type="text" name="residenza" placeholder="Città/Indirizzo" required>
        <br>
        <input type="submit" value="Registrati">
        <button type="button" onclick="location='login.php'">Accedi</button>
    </form>
    <div id="msgErr"></div>
</body>
</html>
<?php
}
?>
