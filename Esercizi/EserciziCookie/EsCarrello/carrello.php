<!DOCTYPE html>
<html lang="it">
<head>
    <title>Carrello</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_COOKIE['prodotti'])){
            $prodotti = file("prodotti.csv");
            $tot = 0;
            $carrello = explode(":",$_COOKIE['prodotti']);
            foreach($carrello as $prodotto){
                echo "$prodotto<br>";
            }
            foreach($carrello as $item){
                foreach($prodotti as $prodotto){
                    $dati = explode(":", $prodotto);
                    if(trim($dati[0]) == trim($item)){
                        $tot += (float)$dati[1]; 
                    }
                }
            }
            echo "<h3>Totale: " . $tot . " Euro</h3>";
        ?>
        <form method="get" action="carrello.php">
            <input type="submit" name="svuota" value="Svuota carrello">
        </form>
        <?php
            if(isset($_GET['svuota'])){
                setcookie('prodotti', '', time() - 3600);
                header("Location: catalogo.php");
            }
        }
        else{
            echo "<h3>Carrello vuoto</h3>";
        }
        echo '<a href="catalogo.php">Torna al catalogo</a>';
    ?> 
</body>
</html>
