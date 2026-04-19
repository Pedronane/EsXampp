<?php
function getConnessione(){
    $host = "localhost";
    $dbName = "accessi";
    $username = "root";
    $password = "";

    $conn = null;

    try {
        $conn = new PDO("mysql:dbname=$dbName;host=$host",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException) {
        $conn = null; 
    }

    return $conn;
}

function eseguiSelect($q){
    $result = null;

    $conn = getConnessione();

    if ($conn != null) {
        try {

            $stmt = $conn->prepare($q);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException) {
            $result = null; 
        }
    }

    return $result;
}

function eseguiInsert($q){
    $result = null;

    $conn = getConnessione();

    if ($conn != null) {
        try {

            $stmt = $conn->prepare($q);
            $stmt->execute();

            $result = $conn->lastInsertId();

        } catch (PDOException) {
            $result = null; 
        }
    }

    return $result;
}
?>
