<?php
    // Marchesi Pietro 5AI postback.php
    require "funzioni.php";
    $err = "";
    $caso = 0; // 0 = nessun dato 1 = elaborazione 2 = dati non validi
    if(!empty($_GET)){
        if(!isset($_GET['nome']) || !isset($_GET['eta'])){
            $err = "Dati mancanti";
            $caso = 2;
        }
        else{
            if(controllaDati($_GET['nome'],$_GET['eta'], $err)){
                $caso = 1;
                $nome = $_GET['nome'];
                $_GET['eta'];
            } 
            else{
                $caso = 2;
            }
        }
    }
    else
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Postback</title>
</head>
<body>
    <?php
        if(caso == 0){
    ?>
    <form>
        <label for="nome">Nome: </label>
        <input type="text" id="nome" name="nome" placeholder="Nome">
        <br>
        <label for="eta">Eta: </label>
        <input type="number" id="eta" name="eta">
        <br>
        <input type="submit" value="Invia">
    </form>    
    <?php
        }
        else if ($caso == 2){
            echo "<h1>$err</h1>";
        }
        else{
            if($eta < 18)
                echo "<p>Minorenne</p>";
            else
                echo "<p>Maggiorenne</p>";
        }
    ?>
</body>
</html>