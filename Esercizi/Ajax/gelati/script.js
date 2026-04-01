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
            stampaGelati(this.responseText);
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
