<?php
// Marchesi Pietro 5AI conDB.php
function getConnessione(){
    $host = "localhost";
    $dbName = "accessi";
    $username = "root";
    $password = "";

    $conn = null;

    try {
        $conn = new PDO("mysql:dbname=$dbName;host=$host", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        $conn = null;
    }

    return $conn;
}

function eseguiSelect($q, $parametri = []){
    $result = null;

    $conn = getConnessione();

    if ($conn != null) {
        try {
            $stmt = $conn->prepare($q);
            $stmt->execute($parametri);
            $result = $stmt->fetchAll();
        } catch (PDOException $e) {
            $result = null;
        }
    }

    return $result;
}

function eseguiInsert($q, $parametri = []){
    $result = null;

    $conn = getConnessione();

    if ($conn != null) {
        try {
            $stmt = $conn->prepare($q);
            $stmt->execute($parametri);
            $result = $conn->lastInsertId();
        } catch (PDOException $e) {
            $result = null;
        }
    }

    return $result;
}

function eseguiUpdate($q, $parametri = []){
    $result = null;

    $conn = getConnessione();

    if ($conn != null) {
        try {
            $stmt = $conn->prepare($q);
            $stmt->execute($parametri);
            $result = $stmt->rowCount();
        } catch (PDOException $e) {
            $result = null;
        }
    }

    return $result;
}
?>