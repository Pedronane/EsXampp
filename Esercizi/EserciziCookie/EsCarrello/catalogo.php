<?php
    if(isset($_COOKIE['prodotti']) && isset($_GET['prodotto'])){
        setcookie("prodotti",$_COOKIE['prodotti'].":".$_GET['prodotto'],time() + 3600);
    }
    elseif (isset($_GET['prodotto'])){
        setcookie("prodotti",$_GET['prodotto'],time() + 3600);
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Catalago</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="">
        <select name="prodotto">
            <?php
                $prodotti = file("./prodotti.csv");
                foreach ($prodotti as $r){
                    [$p, $c] = explode(":",$r,2);
                    echo "<option value="."$p".">$p, Costo: $c</option>";
                }
            ?>
        </select>
            <?php

                if(isset($_COOKIE['prodotti'])){
                    $num = count(explode(":",$_COOKIE['prodotti']));
                    if (isset($_GET['prodotto']))
                        $num ++;
                    echo "<a href='carrello.php'>Carrello($num)</a>";
                }
                elseif (isset($_GET['prodotto']))
                    echo "<a href='carrello.php'>Carrello(1)</a>";
                else
                    echo "<a href='carrello.php'>Carrello(0)</a>";
            ?>
            <br>
            <input type="submit" value="Aggiungi al carrello">
    </form> 
</body>
</html>
