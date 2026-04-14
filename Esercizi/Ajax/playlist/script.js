function mostraBrani(from) {
    let categoria = from.categoria.value;

    if(categoria == ""){
        document.getElementById("ris").innerHTML="";
    }
    else{
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", "server.php?categoria="+categoria);
        xhttp.onload = function(){
            stampaBraniPerCategoria(this.responseText);
        }
        xhttp.send();
    }
}

function stampaBraniPerCategoria(risServer){
    let risBrani = JSON.parse(risServer);
    let divRis = document.getElementById("ris");

    if(risBrani == "ERR_CONN")
        divRis.innerHTML = "Errore connessione";
    else if(risBrani.length == 0 )
        divRis.innerHTML = "Non sono stati trovati brani con questa categoria";
    else{
        let tblBrani = "<table border=1><thead><th>Nome</th><th>categoria</th><th>Durata</th></thead><tbody><tr>";
        for (let i = 0; i < risBrani.length; i++) {
            tblBrani += "<td>" + risBrani[i]['nome'] + "</td>";
            tblBrani += "<td>" + risBrani[i]['categoria'] + "</td>";
            tblBrani += "<td>" + risBrani[i]['durata'] + "</td>";
        }
        tblBrani += "</tr></tbody></table>";
        divRis.innerHTML = tblGelati;
    }
         
}