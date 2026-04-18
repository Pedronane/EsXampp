<?php
include_once "funzioni.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $categoria = $_POST["categoria"] ?? "";
    $query = "SELECT * FROM brani b
        INNER JOIN playlist_brani pb ON pb.id_brano = b.idB
        INNER JOIN playlist p ON pb.id_playlist = p.idP
        INNER JOIN utenti u ON p.username = u.username
        WHERE categoria LIKE '%$categoria%';";
    $risultato = eseguiQuery($query);
    echo json_encode($risultato);
} else {
    echo json_encode("ERR_CONN");
}
?>
