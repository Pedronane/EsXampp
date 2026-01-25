<?php
// Marchesi Pietro register.php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
  if ($_SESSION['role'] == "admin") {
    header("Location: admin.php");
  } else {
    header("Location: index.php");
  }
} else {
?>
  <!DOCTYPE html>
  <html lang="it">

  <head>
    <meta charset="UTF-8">
    <title>Register</title>
  </head>

  <body>
    <h1>Register</h1>
    <form method="POST" action="checkUser.php">
      <label for="user">Username: </label>
      <input type="text" name="user" id="user" placeholder="Username">
      <br>
      <label for="passwd">Password: </label>
      <input type="password" id="passwd" name="passwd" placeholder="Password">
      <br>
      <label for="confirm">Password: </label>
      <input type="password" id="confirm" name="confirm" placeholder="Confirm password">
      <br>
      <input type="submit" value="Register">
    </form>
    <?php
    if (isset($_COOKIE['error'])) {
      $error = $_COOKIE['error'];
      echo "<h1>$error</h1>";
    }
    ?>
    <a href="login.php">Login</a>
    <a href="index.php"><button>Homepage</button></a>
  </body>

  </html>
<?php
}
?>
