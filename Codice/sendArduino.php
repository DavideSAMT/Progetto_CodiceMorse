<?php
$arduino_ip   = '200.200.200.2';
$arduino_port = 8888;
$message = $_POST["prova"];
print "IP $arduino_ip, port $arduino_port, $message";
if ($socket = socket_create ( AF_INET , SOCK_DGRAM , SOL_UDP )) {
    socket_sendto($socket, $message, strlen($message), 0, $arduino_ip, $arduino_port);
} else {
  print("can't create socketn");
}

//Richiamo la pagina index.php
//header("Location: index.php");
?>
