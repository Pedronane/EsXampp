<?php
session_start();
if(isset($_SESSION['user']))
    header("location: homepage.php");
else{
?>
<html lang="en">
<head>
    <title>Login</title>
    <script src="script.js"></script>
</head>
<body>
    <h1>Login</h1>
    <form name="frmLogin" onsubmit="cercaUser(this); return false;" required>
        <input type="text" name="username" placeholder="username" required>
        <input type="text" name="password" placeholder="password">
        <input type="submit" value="login">
    </form>
    <div id="msgErr"></div>
    
</body>
</html>
<?php
}
?>