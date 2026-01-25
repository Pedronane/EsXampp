<?php
function leggiArticoli($nomeFile) {
    $righe = file($nomeFile); //Legge l'intero file in un vettore
    $articoli = [];

    for ($i = 1; $i < count($righe); $i++) {
        $campi = explode(";", trim($righe[$i]));
        $articoli[] = [
            "codice" => $campi[0],
            "descrizione" => $campi[1],
            "tipologia" => $campi[2],
            "prezzo" => floatval($campi[3])
        ];
    }
    return $articoli;
}
?>
