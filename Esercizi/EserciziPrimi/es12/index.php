<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Marchesi Pietro 5AI index.php-->
    <meta charset="UTF-8">
    <title>Es 12</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(!file_exists("articoli.csv")){
            echo("<h1 id='nodata'>No data</h1>");
        }
        else{
            include "funzioni.php";
            $articoli = leggiArticoli("./articoli.csv"); 
            if(empty($articoli)){ // Non saprei come fare se il file esiste ma è vuoto
                echo("<h1 id='nodata'>No data</h1>");
            }
            else{
                $prezzi = array_column($articoli, 'prezzo');
                $max_prezzo = max($prezzi);
                if(!isset($_GET["prezzo_max"]))
                    $prezzo_max = $max_prezzo;
                else
                    $prezzo_max = $_GET["prezzo_max"];
                if(!isset($_GET["filtro"]))
                    $filtro = "tutte";
                else
                    $filtro = $_GET["filtro"];
                if(!isset($_GET["ricerca"]))
                    $ricerca = "";
                else{
                    $ricerca = strtolower(trim($_GET["ricerca"]));
                    $ricercaoriginal = $_GET["ricerca"];
                }
    ?>
                <form method="get" action="">
                    <select name='filtro' id='filtro' onchange="this.form.submit()">
                        <option value="tutte">Tutte</option>
                        <option value="informatica"<?php if($filtro == 'informatica'){ echo'selected';}?>>Informatica</option>
                        <option value="cartoleria"<?php if($filtro == 'cartoleria'){ echo'selected';}?>>Cartoleria</option>
                        <option value="audio"<?php if($filtro == 'audio'){ echo'selected';}?>>Audio</option>
                    </select>

                    <label for="prezzo_max">Prezzo massimo: <?php echo $prezzo_max; ?> €</label>
                    <input type="range" id="prezzo_max" name="prezzo_max" min="0" max="<?php echo $max_prezzo; ?>" step="1" value="<?php echo $prezzo_max; ?>" oninput="this.nextElementSibling.value = this.value">
                    <?php echo $prezzo_max; ?>

                    <label for="ricerca">Ricerca: </label>
                    <input type="text" name="ricerca" id="ricerca" value="<?php if(isset($ricercaoriginal)){echo"$ricercaoriginal";}else{echo"";}?>">

                    <button type="submit">Cerca</button>
                </form>
                <table>
                    <tr>
                        <th>Codice</th>
                        <th>Descrizione</th>
                        <th>Tipologia</th>
                        <th>Prezzo</th>
                    </tr>

    <?php
                foreach($articoli as $articolo){
                    $descrizione = strtolower($articolo['descrizione']);     
                    if(($filtro == 'tutte' || $articolo['tipologia'] == $filtro) && $articolo['prezzo']<=$prezzo_max && ($ricerca == "" || strpos($descrizione, $ricerca) !== false)){
                        echo "<tr>";
                        foreach($articolo as $k => $v){
                            if ($k == "prezzo"){
                                echo "<td>$v"."€</td>";
                            }
                            else
                                echo "<td>$v</td>";
                        }
                        echo "</tr>";
                    }
                }
            }
        }
    ?>
                </table>
</body>
</html>