<?php
function connDB(){
    $host = "localhost";
    $dbName = "gelateria";
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

function eseguiQuery($query){
    $ris = null;
    $conn = connDB();
    if ($conn != null) {
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $ris = $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException) {
            $ris = null; 
        }
    }

    return $ris;
}

?>
