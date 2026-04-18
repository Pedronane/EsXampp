<html>
<body>
<?php 
require "conDB.php";
$sql = "SELECT * FROM  bollette";
$risultato=eseguiQuery($sql);

echo"<pre>";
print_r($risultato);
echo"</pre>";
?>
</body>
</html>
