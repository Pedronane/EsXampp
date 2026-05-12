<!-- Marchesi Pietro 5AI palindromo.php -->
<?php
    function palindroma($string) {
        $string = strtolower(str_replace(" ", "", $string));
        return $string === strrev($string);
    }
    if(palindroma($_GET['testo'])) {
        echo "La stringa è palindroma<br>";
    } else {
        echo "La stringa non è palindroma<br>";
    }
?>