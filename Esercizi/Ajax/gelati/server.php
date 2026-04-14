<?php
include_once "funzioni.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $data = $_POST["data"] ?? "";
    $prod = $_POST["prod"] ?? "";
    $query = "SELECT * FROM gelati WHERE nome LIKE '%$nome%';";
    $risultato = eseguiQuery($query);
    echo json_encode($risultato);
} else {
    echo json_encode("ERR_CONN");
}
?>
