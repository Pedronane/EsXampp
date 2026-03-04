//Marchesi Pietro 5AI 04/03/2026 script.js
function checkUser(form) {
    let user = form.user.value;
    let psw = form.passwd.value;
    if(user == "" || psw == "")
        document.getElementById("ris").innerHTML = "";
    else{
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "checkUser.php");
        xhttp.onload = function(){
            stampaRis(this.responseText);
        }
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("user="+user+"&passwd="+psw);
    }
    return false;
}

function stampaRis(risServer){
    let ris = JSON.parse(risServer);
    let risHTML = "";
    if(ris == "ERR_CONN")
        risHTML = "Errore - nessuna connessione al server";
    else if(ris.length == 0)
        risHTML = "Nessun Utente trovato con questo username o password";
    document.getElementById("err").innerHTML = risHTML;
}