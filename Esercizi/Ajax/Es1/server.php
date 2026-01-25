<?php
    if (isset($_GET['nome']))
        $ris = "Nome: ". $_GET['nome'];
    else
        $ris = "Dati non presenti";
    echo "$ris";
?>
