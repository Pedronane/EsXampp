<?php
session_start();
if(!isset($_SESSION['user']))
    header("Location: login.php");
else{
    require_once("funzioni.php");
    $user = $_SESSION['user'];
    $query = "SELECT b.* from playlists AS p INNER JOIN brani AS b ON b.idBrano = p.idBrano WHERE idUtente = '$user';";
    $braniUsr = eseguiQuery($query);
    if($braniUsr == 0)
        $listaBrani = "Errore connessione";
    else if (count($braniUsr) == 0)
        $listaBrani = "Nessun brano presente nella playlist";
    else{
        $listaBrani = "<ul>";
        foreach($braniUsr as $u){
            $listaBrani .= "<li>" . $u[1] . "-" . $u[2] . "-" . $u[3] . "</li>";
        }
        $listaBrani .= "</ul>";
    }
}
?>
    <html lang="en">
    <head>
        <title>VisualizzaPLyalist</title>
    </head>
    <body>
        <?= $listaBrani ?>
    </body>
        
    </html>