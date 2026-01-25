function ricercaParola(form) {
    let parola = form.parola.value;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        stampaParole(xhttp);
    }
    xhttp.open("POST", "serverDiz.php");
    xhttp.setRequestHeader("Content-Type", "application/x-")
    xhttp.send("par="+parola);
}

function stampaParole(xhttp) {
    let paroleTrovate = JSON.parse(xhttp.responseText);
    let ris = "";
    if (paroleTrovate.lenght == 0) {
        ris = "Non ci sono parole"; 
    }else
    {
        ris = "<table borser=1><thead><th>Parola</th><th>Definizione</th></thead><tbody>"
        for (let i = 0; i < paroleTrovate.length; i++) {
            ris += "<tr><td>" + paroleTrovate[i][0] + "</td><td>" + paroleTrovate[i][1] + "</td></tr>";
        }
        ris += "</tbody></table>";
    }
    document.getElementById("tbris").innerHTML = ris;
}
