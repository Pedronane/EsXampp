<!-- Marchesi Pietro 5AI pag3.php-->
<?php
    $colore;
    if(!empty($_GET)){
        $colore = $_GET["colore"];
        setcookie("colorePag", $colore);
    } else if(isset($_COOKIE['colorePag'])){
        $colore = $_COOKIE["colorePag"];
    }
    else
        $colore = "#FFF";

    if(isset($_COOKIE['visite3'])){
        $visite = $_COOKIE['visite3'] + 1;
        setcookie("visite3",$visite,time() + 60 * 60 * 24 * 30);
    }
    else{
        $visite = "1";
        setcookie("visite3",0,time() + 60 * 60 * 24 * 30);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pagina 3</title>
    </head>
    <body style='background-color: <?php echo $colore;?>'>
        <a href="pag2.php"><button><-</button></a>
        <p>Visite: <?php echo "$visite" ?></p>
    </body>
</html>