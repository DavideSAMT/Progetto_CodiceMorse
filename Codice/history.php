<!doctype html>
<html lang="en">
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
</head>

<body oncontextmenu="return false;">


  <div class="container">
    <header class="header clearfix">
      <nav>
        <ul class="nav nav-pills float-right">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Traduttore</a>
          </li>
          <li class="nav-item">

            <a class="nav-link active" href="history.php">Storico <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </nav>
      <h3 class="text-muted">Codice Morse</h3>
    </header>

    <main role="main">

      <br>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Testo</th>
            <th>Traduzione</th>
          </tr>
        </thead>
        <tbody id="print">
          <?php

          require_once('db_connection.php');
          
          //Prendo i valori dal db
          $sql = "SELECT encoded, decoded FROM code ORDER BY id DESC";
          $result = $conn->query($sql);

          //Se esistono valori
          if ($result->num_rows > 0) {
            //Stampo i valori di ogni riga in una tabella
            while($row = $result->fetch_assoc()) {
              echo "<tr>
              <td>".htmlspecialchars($row["decoded"])."</td>
              <td>".htmlspecialchars($row["encoded"])."</td>
              </tr>";
            }
          }

          //Chiudo la connessione
          $conn->close();
          ?>
        </tbody>
      </table>
      <br>
      <br>
      <p id="demo"></p>
    </main>

    <footer class="footer">
      <p>&copy; CPT 2017</p>
    </footer>

  </div> <!-- /container -->
</body>
</html>
