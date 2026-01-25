<!--Marchesi Pietro 5AI pag1.php-->
<?php
    if(isset($_COOKIE['colorePag']))
        $colore = $_COOKIE['colorePag'];
    else
        $colore = "#FFF";

    if(isset($_COOKIE['visite1'])){
        $visite = $_COOKIE['visite1'] + 1;
        setcookie("visite1",$visite,time() + 60 * 60 * 24 * 30);
    }
    else{
        $visite = "1";
        setcookie("visite1",0,time() + 60 * 60 * 24 * 30);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Scegli il colore</title>
    </head>
    <body style='background-color: <?php echo $colore;?>'>
        <form action="pag2.php">
            Colore: <input type="color" name="colore"> <br>
            <input type="submit" value="Invia">
        </form>       
        <p>Visite: <?php echo "$visite" ?></p>
        <p>Ultimo accesso: <?php $_COOKIE['visite1']?></p>
    </body>
</html>