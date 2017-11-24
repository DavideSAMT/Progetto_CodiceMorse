var morse = new Array();

//Letters
morse[0] = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0',' ');

//Morse
morse[1]=new Array(".-", "-...", "-.-.", "-..", ".", "..-.", "--.", "....", "..", ".---", "-.-", ".-..", "--", "-.", "---", ".--.", "--.-", ".-.", "...", "-", "..-", "...-", ".--", "-..-", "-.--", "--..",".----","..---","...--","....-",".....","-....","--...","---..","----.","-----", "/");

//Converter method
function stringToMorseConverter(string) {
	var result="";

	for (var i = 0; i < string.length; i++) {
		for (var x = 0; x < morse[0].length; x++) {
			if (string[i].toUpperCase()==morse[0][x]) {
				result+=morse[1][x]+" ";
			}
		}
	}

	//return result;
	document.getElementById('a').value=result;
	document.getElementById('b').innerHTML=result;
}

