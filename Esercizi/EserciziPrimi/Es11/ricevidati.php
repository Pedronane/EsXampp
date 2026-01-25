<!-- Marchesi Pietro 5AI ricevidati.php -->

<?php
    if (!isset($_GET["peso"]) || !isset($_GET["altezza"])){
        echo "Peso o altezza non settati";
    }
    else{
        $peso = (int) $_GET["peso"];
        $altezza = (int) $_GET["altezza"] / 100;
    
        if($peso < 10 || $altezza < 0.5){
            echo "Peso o altezza errati";
        }
        else{
            $imc = round($peso / pow($altezza,2),2);
            $img = 0;
            echo "IMC: $imc <br>";
            if ($imc < 18.5){
                echo "Sottopeso";
                $img = 1;
            }
            elseif ($imc < 24.9){
                echo "Normopeso";
                $img = 2;
            }
            elseif ($imc < 29.9){
                echo "Sovrappeso";
                $img = 3;
            }
            else{
                echo "Obeso";
                $img = 4;
            }
            echo "<br>";
            echo "<img src='../img/$img.jpg' alt='Immagine Peso' height='150px' width='150px'>";
        }
        echo"<br>";
        echo "<a href='Es.php'>GO BACK</a>";
    }
?>