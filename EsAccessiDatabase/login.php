<?php
// Marchesi Pietro 5AI login.php
session_start();
if(isset($_SESSION['userId']))
    header("location: index.php");
else{
?>
<html lang="it">
<head>
    <title>Login</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Login</h1>
    <form name="frmLogin" onsubmit="cercaUser(this); return false;">
        <input type="text" name="mail" placeholder="Email" required>
        <br>
        <input type="password" name="passwd" placeholder="Password" required>
        <br>
        <input type="submit" value="Accedi">
        <button type="button" onclick="location='registrazione.php'">Registrati</button>
    </form>
    <div id="msgErr"></div>
</body>
</html>
<?php
}
?>
