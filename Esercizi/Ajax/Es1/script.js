function inviaDati(form) {
    let nome = form.nome.value; 
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("ris").innerHTML = this.responseText;;
    }
    xhttp.open("GET", "server.php?nome="+nome);
    xhttp.send();
}
