<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>History</title>
</head>
<body>
	
</body>
</html>

<?php
}
else
	header("Location:index.php");
?>
