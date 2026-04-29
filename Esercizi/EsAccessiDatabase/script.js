function cercaUser(frmLogin){
    let mail = frmLogin.mail.value;
    let passwd = frmLogin.passwd.value;

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "checkuser_ajax.php");
    xhttp.onload = function(){
        stampaLogin(this);
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("mail=" + mail + "&passwd=" + passwd);
}

function stampaLogin(xhttp){
    let ris = JSON.parse(xhttp.responseText);
    const divErr = document.getElementById('msgErr');

    if(ris == "ERR_CONN")
        divErr.innerHTML = "Errore connessione al database";
    else if(ris == "NO_USR")
        divErr.innerHTML = "Email o password errati";
    else if(ris == "OK_ADMIN")
        location = 'admin.php';
    else
        location = 'user.php';
}

function registraUser(frmReg){
    let nome = frmReg.nome.value;
    let cognome = frmReg.cognome.value;
    let mail = frmReg.email.value;
    let dataNascita = frmReg.dataNascita.value;
    let sesso = frmReg.sesso.value;
    let passwd = frmReg.password.value;
    let confermaPasswd = frmReg.confermaPassword.value;
    let telefono = frmReg.telefono.value;
    let residenza = frmReg.residenza.value;
    const divErr = document.getElementById('msgErr');

    if(passwd.length < 8){
        divErr.innerHTML = "La password deve avere almeno 8 caratteri";
        return;
    }

    if(passwd != confermaPasswd){
        divErr.innerHTML = "Le password non corrispondono";
        return;
    }

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "registrazione_ajax.php");
    xhttp.onload = function(){
        stampaRegistrazione(this);
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nome=" + nome + "&cognome=" + cognome + "&email=" + mail +
                "&dataNascita=" + dataNascita + "&sesso=" + sesso +
                "&password=" + passwd + "&telefono=" + telefono + "&residenza=" + residenza);
}

function stampaRegistrazione(xhttp){
    let ris = xhttp.responseText;
    const divErr = document.getElementById('msgErr');

    if(ris == "ERR_CONN")
        divErr.innerHTML = "Errore connessione al database";
    else if(ris == "EMAIL_ESI")
        divErr.innerHTML = "Email già registrata";
    else if(ris == "TEL_ESI")
        divErr.innerHTML = "Telefono già registrato";
    else if(ris == "ERR_REG")
        divErr.innerHTML = "Errore nella registrazione";
    else
        location = 'login.php';
}
