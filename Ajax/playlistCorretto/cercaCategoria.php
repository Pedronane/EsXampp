<?php
session_start();
if(!isset($_SESSION['user']))
    header("Location: login.php");
else{
    require_once("funzioni.php");
    $query = "SELECT * FROM categorie;";
    $cat = eseguiQuery($query);
    $opzCat = "<select name='cat'>";
    foreach($cat as $c){
        $opzCat .= "<option value='".$c[0] ."'>" . $c[1] . "</option>";
    }
    $opzCat .= "</select>";
}

?>
    <html lang="en">
    <head>
        <title>VisualizzaPLyalist</title>
        <script src="script.js"></script>
    </head>
    <body>
        <form name="frmCat" onsubmit="cercaBraniCat(this); return false;">
             <?= $opzCat ?>
             <input type="submit" value="Cerca brani">
        </form>
       <div id="msg"></div>
    </body>
        
    </html>