<?php
header("Content-Type: application/json; charset=utf-8");

include_once "conDB.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $data = $_POST["data"] ?? "";
    $prod = $_POST["prod"] ?? "";
    $query = "SELECT * FROM gelati WHERE nome=$nome";
    $risultato = eseguiQuery($query);
    echo json_encode($risultato);
} else {
    echo json_encode("ERR_CONN");
}
?>
