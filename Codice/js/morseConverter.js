//Reegex deve contenere almeno una lettera o un numero
var spaceRegex = /[a-z]+|[0-9]+/g;

//Creazione di array bidimensionale con lettere alfabetiche e morse
var morse = new Array();
morse[0] = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0',' ');
morse[1] = new Array(".-", "-...", "-.-.", "-..", ".", "..-.", "--.", "....", "..", ".---", "-.-", ".-..", "--", "-.", "---", ".--.", "--.-", ".-.", "...", "-", "..-", "...-", ".--", "-..-", "-.--", "--..",".----","..---","...--","....-",".....","-....","--...","---..","----.","-----", "/");

//Metodo che controlla la validità del testo inserito
function controlInputTextarea(){

  var input = document.getElementsByName("inputTextarea")[0].value;

  if(!input.match(spaceRegex)){
    //Disabilito bottone submit e cancello il contenuto nel paragrafo
    document.getElementsByName("checkButton")[0].disabled = true;
    document.getElementsByName("outputText")[0].innerHTML = "";
  }else{
    //Abilito bottone submit e invio testo al metodo che converte in morse
    document.getElementsByName("checkButton")[0].disabled = false;
    inputToMorseConverter(input);
  }
}


//Metodo che converte il testo in morse
function inputToMorseConverter(input) {
  var result="";



  for (var i = 0; i < input.length; i++) {
    var special = true;
    for (var x = 0; x < morse[0].length; x++) {
      //Controllo se il carattere é presente nell'array alfabetico
      if (input[i].toUpperCase()==morse[0][x]) {
        //Aggiungo alla variabile il corrispettivo morse del carattere
        result+=morse[1][x]+" ";
        special = false;
      }
    }
    if(special){
      result+="#";
    }
  }

  //Stampo il risultato nel paragrafo
  document.getElementsByName("outputText")[0].innerHTML = result;
}


/*
* Funzione che disabilita il tasto destro
*/
document.addEventListener("contextmenu", function(e){
  alert("This page is Protected by CPT, All Rights Reserved");
  e.preventDefault();
}, false);
/*
* Funzione che disabilita F12
*/
document.onkeypress = function (event) {
  event = (event || window.event);
  if (event.keyCode == 123) {
    alert("This page is Protected by CPT, All Rights Reserved");
    return false;
  }
}
document.onmousedown = function (event) {
  event = (event || window.event);
  if (event.keyCode == 123) {
    alert("This page is Protected by CPT, All Rights Reserved");
    return false;
  }
}
document.onkeydown = function (event) {
  event = (event || window.event);
  if (event.keyCode == 123) {
    alert("This page is Protected by CPT, All Rights Reserved");
    return false;
  }
}
