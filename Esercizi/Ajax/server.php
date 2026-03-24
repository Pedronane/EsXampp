<?php
header("Content-Type: application/json; charset=utf-8");

include_once "funzioni.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $data = $_POST["data"] ?? "";
    $prod = $_POST["prod"] ?? "";
    $risultato = cercaGelati($nome, $data, $prod);
    echo json_encode($risultato);
} else {
    echo json_encode("ERR_CONN");
}
?>
