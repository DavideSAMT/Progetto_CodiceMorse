  <?php
  //Controllo se é stato eseguito il POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once('db_connection.php');
	
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

    
    /////////////////////////////BATABASE////////////////////////////////////////

   //Aggiungo i valori
    $sql = "INSERT INTO code (encoded, decoded)
    VALUES ('$result', '$input')";

    //Stampo il risultato dell'aggiunta dei valori
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    //////////////////////////ARDUINO//////////////////////////////////////

    $result .= "E";

    $arduino_ip   = '192.168.20.2';
    $arduino_port = 8888;
    $mess = "";
    $message = str_replace('#','',$result);
    $message = str_replace(' ','*',$message);
    //$timeSleep;

	
    if ($socket = socket_create ( AF_INET , SOCK_DGRAM , SOL_UDP )) {
      for ($i=0; $i < strlen($message); $i++) {

        socket_sendto($socket, $message[$i], 1, 0, $arduino_ip, $arduino_port);
        echo "<br>".$message[$i];

      usleep(10000);//($timeSleep);
      }        
    }else{
      print("can't create socketn ");
    }
    ///////////////////////////////////////////////////////////////////////////////

    header("Location: index.php");
  }
  ?>