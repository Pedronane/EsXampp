<?php
$dizionario = [
    "papera" => "animale di lago o fiume che fa qua qua",
    "padella" => "utensile da cucina",
    "pino" => "albero natalizio",
    "anaconda" => "Matheus",
];
if (isset($_POST['par'])) {
    $parDaRic = $_POST['par'];
    $ris = [];
    foreach ($dizionario as $parola => $definizione) {
        if(str_contains($parola, $parDaRic)) {
            $ris[$parola] = $definizione;
        }

    }
}else
    $ris = "Errore - dati non inviati";
echo json_encode($ris);
?>
