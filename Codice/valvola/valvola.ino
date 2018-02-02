#include <SPI.h>         // needed for Arduino versions later than 0018
#include <Ethernet.h>
#include <EthernetUdp.h>         // UDP library from: bjoern@cs.stanford.edu 12/30/2008



// Enter a MAC address and IP address for your controller below.
// The IP address will be dependent on your local network:
byte mac[] = {
  0xDE, 0x90, 0xA2, 0xDA, 0x10, 0x95
};
IPAddress ip(200, 200, 200, 2);

unsigned int localPort = 8888;      // local port to listen on

// buffers for receiving and sending data
char packetBuffer[UDP_TX_PACKET_MAX_SIZE];  //buffer to hold incoming packet,
char  ReplyBuffer[] = "acknowledged";       // a string to send back

String result = "";

// An EthernetUDP instance to let us send and receive packets over UDP
EthernetUDP Udp;

void setup() {
  // start the Ethernet and UDP:
  Ethernet.begin(mac, ip);
  Udp.begin(localPort);

  Serial.begin(9600);
}

void loop() {
  // if there's data available, read a packet
  int packetSize = Udp.parsePacket();
  if (packetSize) {
    /*Serial.print("Received packet of size ");
    Serial.println(packetSize);
    Serial.print("From ");
    IPAddress remote = Udp.remoteIP();
    for (int i = 0; i < 4; i++) {
      Serial.print(remote[i], DEC);
      if (i < 3) {
        Serial.print(".");
      }
    }
    Serial.print(", port ");
    Serial.println(Udp.remotePort());*/

    // read the packet into packetBufffer
    Udp.read(packetBuffer, UDP_TX_PACKET_MAX_SIZE);
    /*Serial.println(UDP_TX_PACKET_MAX_SIZE);
    Serial.println(packetBuffer);*/
    String code = packetBuffer;
        
    //Introdurre 
    //Converto morse in 0 e 1
    for(int i = 0; i < code.length(); i++){
      if(code.charAt(i) == '.'){
        result += code.charAt(i);
      }else if(code.charAt(i) == '-'){
        result += code.charAt(i);
      }else if(code.charAt(i) == 'E'){
        Serial.println("FINE");
        result = "";
      }
    }
    Serial.println(result);
    //Resetto buffer
    for(int i = 0; i < UDP_TX_PACKET_MAX_SIZE; i++) packetBuffer[i] = 0;
    // send a reply to the IP address and port that sent us the packet we received
    /*Udp.beginPacket(Udp.remoteIP(), Udp.remotePort());
    Udp.write(ReplyBuffer);
    Udp.endPacket();*/
    
  }
  delay(10);
}
