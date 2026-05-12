<!DOCTYPE html>
<html lang="it">
    <head>
        <!-- Marchesi Pietro 5AI Es.php -->
    </head>
    <body>
        <h1>Esercizio 1</h1> 
        <?php
            $date = date("d-m-Y H:i");
            echo($date);
        ?>
        <h1>Esercizio 2</h1>
        <?php
            $n1 = 0;
            $n2 = 1;
            echo("<ul>");
            for($i = 0; $i < 15; $i++){
                $res = $n1 + $n2;
                echo("<li>$n1 + $n2 = $res</li>");
                $n1 = $n2;
                $n2 = $res;
            }
            echo("</ul>");
        ?>
        <h1>Esercizio 3</h1>
        <table border="1">
            <?php
                $num = [];
                echo("<tr>");
                for($i = 0; $i < 10; $i++){
                    $num[$i] = $i+1;
                    echo("<td>".$num[$i]."</td>");
                }
                echo("</tr>");
                for($i = 2; $i <= 10; $i++){
                    echo("<tr>");
                    for($k = 0; $k < 10; $k++){
                        $res = $i * $num[$k];
                        echo("<td>".$res."</td>");
                    }
                    echo("</tr>");
                }
            ?>
        </table>
        <h1>Esercizio 4</h1>
        <table border="1">
            <tr>
                <th>n</th>
                <th>radice</th>
                <th>qudrato</th>
                <th>cubo</th>
            </tr>
            <?php
                for($i = 1; $i <= 15; $i++){
                    echo("<tr>");
                    echo("<td>".$i."</td>");
                    echo("<td>".round(sqrt($i),2)."</td>");
                    echo("<td>".pow($i,2)."</td>");
                    echo("<td>".pow($i,3)."</td>");
                    echo("</tr>");
                }
            ?>
        </table>
        <h1>Esercizio 5</h1>
        <table border="1">
            <tr>
                <th>dec</th>
                <th>bin</th>
                <th>carattere</th>
            </tr>
            <?php
                for($i = 33; $i <= 127; $i++){
                    echo("<tr>");
                    echo("<td>".$i."</td>"); 
                    echo("<td>".str_pad(decbin($i), 7, "0", STR_PAD_LEFT)."</td>"); 
                    echo("<td>".chr($i)."</td>"); 
                    echo("</tr>");
                }
            ?>
        </table>
        <h1>Esercizio 6</h1>
        <?php
            $estrazione = [];
            while (count($estrazione) < 5) {
                $numero = rand(1, 90);
                if (!in_array($numero, $estrazione)) {
                    $estrazione[] = $numero;
                }
            }

            sort($estrazione);
            echo "Numeri estratti (ordinati): ";
            foreach ($estrazione as $num) {
                echo $num . " ";
            }
            echo "\n";
        ?>
        <h1>Esercizio 7</h1>
        <?php
            function calcolaFat($n){
                $res = 1;
                for($i = $n; $i > 0; $i--){
                    $res = $res * $i;
                }
                return($res);
            }
            for($i = 1; $i <= 50; $i++){
                echo "$i! =".calcolaFat($i)."<br>";
            }
        ?>
        <h1>Esercizio 8</h1>
        <form method="get" action="palindromo.php">
            <input type="text" name="testo">
            <input type="submit" value="Invia">
        </form>
        <h1>Esercizio 9</h1>
        <?php
            $n = rand(1,10);
            immagine($n);
            function immagine($n){
                echo "<img alt='img casuale' src='./img/$n.jpg' width='400px' height='500px'>";
            }
        ?>
        <h1>Esercizio 10</h1>
        <?php
            $nums = [];
            $len = 20;
            for($i = 0; $i < $len; $i++){
                $nums[$i] = rand(1,500);
                echo $nums[$i]."<br>";
            }
            $max = $nums[0];
            for($i = 0; $i < $len; $i++){
                if($nums[$i] > $max )
                    $max = $nums[$i];
            }
            echo "Il numero massimo è: $max <br>";
            $min = $nums[0];
            for($i = 0; $i < $len; $i++){
                if($nums[$i] < $min )
                    $min = $nums[$i];
            }
            echo "Il numero minimo è: $min <br>";
            $sum = 0;
            for($i = 0; $i < $len; $i++){
                $sum = $sum + $nums[$i];
            }
            $media = $sum / $len;
            echo "La media è: $media <br>";
            $pari = 0;
            $dispari = 0;
            for($i = 0; $i < $len; $i++){
                if($nums[$i] % 2 == 0)
                    $pari += 1;
                else
                    $dispari += 1;
            }
            echo "I numeri pari sono: $pari <br>";
            echo "I numeri dispari sono: $dispari <br>";
            $var = 0;
            for($i = 0; $i < $len; $i++)
    		    $var += ($nums[$i] - $media) ** 2;
		
	        $var = sqrt($var / $len);
            echo "La deviazione standard è:".round($var, 2)."<br>";
        ?>
    </body>
</html>