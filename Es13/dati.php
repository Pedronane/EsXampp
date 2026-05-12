<?php
    //Marchesi Pietro 5AI dati.php
function controlladati($n, $scelte, &$err){
    // L'array associativo è formato da un campo chiave che mi dice il nome del convegno associato a una descrizione
    $convegni = [
        'Vim' => 'Descrizione dell\'editor di testo Vim',
        'Linux' => 'Descrizione del sistema operativo Linux',
        'AI' => 'Intelligenza Artificiale',
        'Cybersecurity' => 'Corso sulla cybersecurity',
    ];
    $check = true;
    if ($n == "") {
        $err = "Nome non valido";
        $check = false;
    }
    elseif (strlen($n) < 3){
        $err = "Nome troppo corto";
        $check = false;
    }
    foreach ($scelte as $scelta) {
        if (!array_key_exists($scelta,$convegni)) {
            $check = false;
            $err = "Scelta non valida";
        }
    }
    return $check;
}
?>
