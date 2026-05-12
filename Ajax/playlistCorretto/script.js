function cercaUser(frmLogin){
    let usr = frmLogin.username.value;
    let psw = frmLogin.password.value;
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "api_login.php");
    xhttp.onload = function(){
        stampaLogin(this);
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("usr=" + usr + "&psw=" + psw);
}

function stampaLogin(xhttp){
    let risSever = xhttp.responseText;
    const divRis = document.getElementById('msgErr');
    if(risSever == "ERR_CONN")
        divRis.innerHTML = "Errore connessione";
    else if (risSever == "NO_USR")
        divRis.innerHTML = "Credenziali errate";
    else
        location = 'homepage.php';
}

function cercaBraniCat(frmCat){
    let cat = frmCat.cat.value;
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "api_cercaBraniCat.php?cat=" + cat);
    xhttp.onload = function(){
        stampaBraniCat(this);
    };
    xhttp.send();
}

function stampaBraniCat(xhttp){
    let risServer = JSON.parse(xhttp.responseText);
    const divRis = document.getElementById('msg');
    if(risServer == "ERR_CONN")
        divRis.innerHTML = "Errore connessione";
    else if (risServer.length == 0)
        divRis.innerHTML = "Non ci sono brani";
    else{
        //stampa tabella
        alert(risServer.length);
    }

}