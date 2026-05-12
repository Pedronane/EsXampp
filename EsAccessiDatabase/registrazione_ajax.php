<?php
/*
    ERR_CONN = errore connessione db
    EMAIL_ESI = email già esistente
    TEL_ESI  = telefono già esistente
    ERR_REG  = errore inserimento
    OK_REG   = registrazione ok
*/
require_once('conDB.php');

if(!isset($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['dataNascita'],
          $_POST['sesso'], $_POST['password'], $_POST['telefono'], $_POST['residenza']))
    header("location: registrazione.php");
else{
    $nome       = trim($_POST['nome']);
    $cognome    = trim($_POST['cognome']);
    $email      = strtolower(trim($_POST['email']));
    $dataNascita= trim($_POST['dataNascita']);
    $sesso      = trim($_POST['sesso']);
    $passwd     = trim($_POST['password']);
    $telefono   = trim($_POST['telefono']);
    $residenza  = trim($_POST['residenza']);

    // controllo email
    $queryEmail = "SELECT idU FROM utenti WHERE email = :email;";
    $risEmail = eseguiSelect($queryEmail, [":email" => $email]);

    if($risEmail == null){
        echo "ERR_CONN";
        exit;
    }
    if(count($risEmail) > 0){
        echo "EMAIL_ESI";
        exit;
    }

    // controllo telefono
    $queryTel = "SELECT idU FROM utenti WHERE telefono = :tel;";
    $risTel = eseguiSelect($queryTel, [":tel" => $telefono]);

    if($risTel == null){
        echo "ERR_CONN";
        exit;
    }
    if(count($risTel) > 0){
        echo "TEL_ESI";
        exit;
    }

    // inserimento
    $query = "INSERT INTO utenti (idU, nome, cognome, dataNascita, sesso, email, password, telefono, residenza, tipo)
              VALUES (NULL, :nome, :cognome, :dataNascita, :sesso, :email, :passwd, :telefono, :residenza, 1);";
    $parametri = [
        ":nome"       => $nome,
        ":cognome"    => $cognome,
        ":dataNascita"=> $dataNascita,
        ":sesso"      => $sesso,
        ":email"      => $email,
        ":passwd"     => $passwd,
        ":telefono"   => $telefono,
        ":residenza"  => $residenza
    ];

    $ris = eseguiInsert($query, $parametri);

    if($ris == null)
        echo "ERR_REG";
    else
        echo "OK_REG";
}
?>
