<!DOCTYPE html>
<html>
    <head>
        <title>Gelateria</title>
        <script src="script.js"></script>
    </head>
    <body>
        <h1>Gelateria</h1>
        <form name="form" onsubmit="return false">
            Nome Gelato:
            <input type="text" name="nome" id="nome" oninput="mostraGelati(form)">
            <br>
            Data Scadenza:
            <input type="date" name="data" id="data" oninput="mostraGelati(form)">
            <br>
            Produttore:
            <input type="text" name="prod" id="prod" oninput="mostraGelati(form)">
        </form>
        <div id="ris"></div>
    </body>
</html>
