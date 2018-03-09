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

//Funzione che disabilita il bottone di invio dopo il submit.
function disabledButton(){
    document.getElementsByName("checkButton")[0].disabled = true;
}
