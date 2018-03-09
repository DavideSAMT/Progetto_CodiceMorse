<?php 
 //Connessione al db mysql
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "morsecode";
    $port = 3306;

    // Creo la connessione
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Controllo la connessione
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>

