function mostraGelati(form) {
    let nome=form.nome.value;
    let data=form.data.value;

    if(data !== "") {
        const date = new Date(data + 'T00:00:00');
        data = date.toLocaleDateString('it-IT');
    }
    let prod=form.prod.value;
    if (nome==""&&data==""&&prod=="")
        document.getElementById("ris").innerHTML="";
    else{
        const xhttp= new XMLHttpRequest();
        xhttp.open("POST","server.php");
        xhttp.onload=function(){
            mostraGelatiPerNome(this.responseText, document.getElementById("ris"));
        }
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send("nome="+nome+"&data="+data+"&prod="+prod);
    }
}
function stampaGelati(risServer){
    let ris=JSON.parse(risServer);
    let risHtml="";
    if (ris=="ERR_CONN")
        risHtml="Errore - nessuna connessione al server";
    else{
        if (!Array.isArray(ris) || ris.length==0)
            risHtml="Non ci sono gelati del genere";
        else{
            risHtml="<table border='1'><thead><th>Nome</th><th>Data Produzione</th><th>Data Scadenza</th><th>Quantità</th><th>Produttore</th></thead><tbody>";
            for (let i=0;i<ris.length;i++){
                risHtml+="<tr>";
                for(let k=0;k<5;k++){
                    risHtml+="<td>"+(ris[i][k] ?? "")+"</td>";
                }
                risHtml+="</tr>";
            }
            risHtml+="</tbody></table>";
        }
    }
    document.getElementById("ris").innerHTML=risHtml;
}

function mostraGelatiPerNome(risServer, divRis){
    let risGelati = JSON.parse(risServer);
    if(risGelati == "ERR_CONN")
        divRis.innerHTML = "Errore connessione";
    else if(risGelati.length == 0)
        divRis.innerHTML = "Nessun gelato trovato";
    else{
        let tblGelati = "<table border=1><thead><th>Nome</th><th>Data produzione</th><th>Data scadenza</th><th>Qty</th><th>Produttore</th></thead><tbody><tr>";
        tblGelati += "<td>" + risGelati[0]['nome'] + "</td>";
        tblGelati += "<td>" + risGelati[0][1] + "</td>";
        tblGelati += "</tr></tbody></table>";
        divRis.innerHTML = tblGelati;
    }
}
