<?php
function cercaGelati($nome, $data, $prod) {
    $righe = file("gelati.csv");
    $risultati = [];

    foreach ($righe as $gelato) {
        $gelato = trim($gelato);
        if ($gelato === "") continue;

        $campi = explode(";", $gelato, 5);
        while (count($campi) < 5) $campi[] = "";

        [$n, $dp, $ds, $q, $p] = $campi;

        $checkN = true;
        $checkD = true;
        $checkP = true;

        if ($nome !== "") {
            $checkN = (strpos($n, $nome) !== false);
        }

        if ($data !== "") {
            $scadenza = strtotime(str_replace("/", "-", $data));
            $input   = strtotime(str_replace("/", "-", $ds));

            if ($scadenza !== false && $input !== false) {
                $checkD = ($input <= $scadenza);
            } else {
                $checkD = (strpos($ds, $data) !== false);
            }
        }

        if ($prod !== "") {
            $checkP = (strpos($p, $prod) !== false);
        }

        if ($checkN && $checkD && $checkP) {
            $risultati[] = [$n, $dp, $ds, $q, $p];
        }
    }

    return $risultati;
}
?>
