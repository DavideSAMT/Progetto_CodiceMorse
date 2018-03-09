<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Progetto SAMT Codice Morse I3AA 2017-2018">
  <meta name="author" content="Agosta, Gomes, Paradiso, Sartori">
  <link rel="icon" href="images/favicon.ico">

  <title>Codice Morse</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">

  <script src="jquery/jquery-3.3.1.min.js"></script>

</head>

<body oncontextmenu="return false;">

  <div class="container">
    <header class="header clearfix">
      <nav>
        <ul class="nav nav-pills float-right">
          <li class="nav-item">
            <a class="nav-link active" href="index.html">Traduttore <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="history.php">Storico</a>
          </li>
        </ul>
      </nav>
      <h3 class="text-muted">Codice Morse</h3>
    </header>


    <main role="main">
      <div class="jumbotron">
        <h1 class="display-3">Traduci il tuo testo...</h1>
        <form class="form" action="data_backup.php" method="post">

          <div class="form-group">
            <textarea maxlength="100" class="form-control" id="inputTextarea" name="inputTextarea"
			value="<?php if(isset($_POST['inputTextarea'])) echo $_POST['inputTextarea']; ?>"
			rows="3" placeholder="Inserisci il testo qui" required>
			</textarea>
          </div>

          <br>

          <p class="output" name="outputText" ></p>

          <br>

          <button name="checkButton" type="submit" class="btn btn-lg btn-success" disabled >Invio</button>
        </form>
      </div>


      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Cos'é il codice Morse?</h4>
          <p>Il codice Morse, detto anche alfabeto Morse, è un sistema per trasmettere lettere, numeri e segni di punteggiatura per mezzo di un segnale in codice ad intermittenza.</p>
        </div>

        <div class="col-lg-6">
          <h4>Cosa puoi codificare?</h4>
          <p>Il codice Morse codifica lettere alfabetiche e numeri, il nostro programma codifica le lettere (A-Z), i numeri (0-9). Gli spazi verranno codificati con '/' mentre i caratteri speciali con '#'.</p>
        </div>
      </div>

    </main>

    <footer class="footer">
      <p>&copy; CPT 2017</p>
    </footer>
  
  </div> <!-- /container -->

<script>
    $(document).ready(function(){
      $('[name="inputTextarea"]').keyup(function() {
        //var regex = new RegExp(/[a-z]+|[0-9]+/g);
        //Creazione di array bidimensionale con lettere alfabetiche e morse
        var morse = new Array();
        morse[0] = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0',' ');
        morse[1] = new Array(".-", "-...", "-.-.", "-..", ".", "..-.", "--.", "....", "..", ".---", "-.-", ".-..", "--", "-.", "---", ".--.", "--.-", ".-.", "...", "-", "..-", "...-", ".--", "-..-", "-.--", "--..",".----","..---","...--","....-",".....","-....","--...","---..","----.","-----", "/");
        var input = $('[name="inputTextarea"]').val();
        if (!input.match(/[a-z]+|[0-9]+/g)) {
          $('[name="checkButton"]').prop("disabled",true);
          $('[name="outputText"]').text("");
        }else{
          $('[name="checkButton"]').prop("disabled",false);
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
        $('[name="outputText"]').text(result);
      }
    });
    //Blocco il tasto invio
    $('form').submit(function() {
      $('[name="checkButton"]').prop("disabled",true);
    });
  });
  </script>
  <script src="js/disable.js"></script>

</body>
</html>