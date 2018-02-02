#include <SPI.h>
#include <Ethernet.h>
#include <EthernetUdp.h>


byte mac[] = {0xDE, 0x90, 0xA2, 0xDA, 0x10, 0x95};
IPAddress ip(200, 200, 200, 2);
unsigned int localPort = 8888;
char packetBuffer[UDP_TX_PACKET_MAX_SIZE];
String result = "";
const int mosfetPin = 7;

EthernetUDP Udp;

void setup() {
  pinMode(mosfetPin,OUTPUT);
  Ethernet.begin(mac, ip);
  Udp.begin(localPort);

  Serial.begin(9600);
}

void loop() {
  
  int packetSize = Udp.parsePacket();
  if (packetSize) {

    // read the packet into packetBufffer
    Udp.read(packetBuffer, UDP_TX_PACKET_MAX_SIZE);
    String code += packetBuffer;
        
    for(int i = 0; i < code.length(); i++){
      switch(code.charAt(i)){
        case '.':
          delay(500);
          break;
        case '-':
          delay(1500);
          break;
        case '/':
          delay(3500);
          break;
        default:
          result = "";
          break;  
      }
    }

    //Resetto buffer
    for(int i = 0; i < UDP_TX_PACKET_MAX_SIZE; i++) packetBuffer[i] = 0;

  }
  delay(1000);
}
