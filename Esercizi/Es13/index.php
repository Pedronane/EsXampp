<?php
    // Marchesi Pietro 5AI index.php
	require "dati.php";

	$msgErr="";
	$stampaForm = true;
	$mostraErrore = false;

	if($_SERVER["REQUEST_METHOD"]==='GET' && !empty($_GET)){
		$stampaForm = false;
		if(!isset($_GET['nome']) || (!isset($_GET['Vim']) && !isset($_GET['Linux']) && !isset($_GET['AI']) && !isset($_GET['Cybersecurity']))){
			$msgErr= "Dati mancanti";
			$mostraErrore = true;
		}
		else{
			$nome=$_GET['nome'];
            $scelte = array();
		    foreach ($_GET as $k => $v) {
                if (isset($k)) {
                    if($k != "nome")
                        array_push($scelte, $v);
                }
		    }	
			if(controllaDati($nome, $scelte, $msgErr)){
				$nome = htmlspecialchars($nome);
			}
			else{
				$mostraErrore = true;
			}
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Esercizio 13</h1>
		<?php
			if($stampaForm){
		?>
		<form onsubmit="return validaForm(event);">
			<input type=text name=nome id=nome placeholder=Nome>
			<br>
				<input type='checkbox' name='Vim' value='Vim'>Vim
				<input type='checkbox' name='Linux' value='Linux'>Linux
				<input type='checkbox' name='AI' value='AI'>AI
				<input type='checkbox' name='Cybersecurity' value='Cybersecurity'>Cybersecurity
			<br>
			<input type=submit value="Iscriviti">
		</form>
		<?php
			}
			elseif ($mostraErrore) {
				// Errore di validazione
				echo "<p style='color:red;'>$msgErr</p>";
				echo "<a href='index.php'>Torna indietro</a>";
			} else {
        echo "<p>Ciao $nome sei iscritto a: </p>";
        echo "<ul>";
        foreach ($scelte as $k) {
            echo "<li>$k</li>";
        }  
			}
		?>
	</body>
</html>
