// Marchesi Pietro 5AI controlli.js
function controlladati(formimc){
    let altezza = document.getElementById("altezza").value;
    let peso = document.getElementById("peso").value;
    let check = false;

    if(isNaN(peso) || isNaN(peso)){
        alert("Peso o altezza devono essere un numero");
    }
    else{
        if(peso < 10 || altezza < 50){
            alert("Peso o altezza sbagliati");
        }
        else{
            check = true;
        }
    }
    return check;
}
