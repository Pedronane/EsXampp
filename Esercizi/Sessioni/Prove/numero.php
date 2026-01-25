<?php
    if(isset($_GET)){
        if($_GET['num'] < 0){
            header($_SERVER['SERVER_PROTOCOL']." 418 Fai schifo");
        }
        else{
            header("location: ok.php");
        }
    }
    else{
        echo "Errore";
    }
?>