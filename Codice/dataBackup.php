<?php
//Controllo se é stato eseguito il POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Creo matrice di array
  $morse = array
  (
    array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0',' '),
    array(".-", "-...", "-.-.", "-..", ".", "..-.", "--.", "....", "..", ".---", "-.-", ".-..", "--", "-.", "---", ".--.", "--.-", ".-.", "...", "-", "..-", "...-", ".--", "-..-", "-.--", "--..",".----","..---","...--","....-",".....","-....","--...","---..","----.","-----", "/")
  );

  $input = $_POST["inputTextarea"];

  $result = "";

  //Ciclo for scorre il testo
  for ($i=0; $i < strlen($input); $i++) {
    $special = true;
    for ($y=0; $y < count($morse[0]); $y++) {
      //Se il testo é alfabetico o numerico aggiunge il morse
      if (strtoupper($input[$i]) == $morse[0][$y]) {
        $result .= $morse[1][$y]." ";
        $special = false;
      }
    }
    //Se non é un carattere alfabetico o numerico aggiungi #
    if ($special) {
      $result .= "#";
    }
  }

  ////////////////////////////////////////////////////////////////////////////////

  //Connessione al db mysql
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "morsecode";

  // Creo la connessione
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Controllo la connessione
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //Aggiungo i valori
  $sql = "INSERT INTO code (encoded, decoded)
  VALUES ('$input', '$result')";

  //Stampo il risultato dell'aggiunta dei valori
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  //Chiudo la connessione
  $conn->close();

  //Richiamo la pagina index.php
  header("Location: index.php");
}
?>
