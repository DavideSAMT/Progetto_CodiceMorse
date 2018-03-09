#include <SPI.h>
#include <Ethernet2.h>
#include <EthernetUdp2.h>


byte mac[] = {0x90, 0xA2, 0xDA, 0x10, 0xE2, 0x45}; //MAC dell'Arduino ethenet
IPAddress ip(192, 168, 20, 2); //IP dell'Arduino ethenet
unsigned int localPort = 8888; //Porta in ascolto dell'Arduino ethenet
char packetBuffer[UDP_TX_PACKET_MAX_SIZE];// Lunghezza massima del Buffered
String code = ""; //Stringa code che conterrà il
const int mosfetPin = 7;
const int pausa = 300; 

EthernetUDP Udp;

void setup() {
  pinMode(mosfetPin,OUTPUT);
  Ethernet.begin(mac, ip);
  Udp.begin(localPort);

  Serial.begin(9600);
}

void loop() {
  
  int packetSize = Udp.parsePacket();
  Serial.println(packetSize);
  
  if (packetSize) {
  
    // read the packet into packetBufffer
    Udp.read(packetBuffer, UDP_TX_PACKET_MAX_SIZE);


    Serial.println(packetBuffer);
    code += packetBuffer;
    
    //Resetto buffer
    for(int i = 0; i < UDP_TX_PACKET_MAX_SIZE; i++) packetBuffer[i] = 0;
    
    if(code.charAt(code.length()-1) == 'E'){
      startStop();
      for(int i = 0; i < code.length(); i++){
        switch(code.charAt(i)){
          case '.':
            digitalWrite(mosfetPin, HIGH);
            delay(pausa);
            break;
          case '-':
            digitalWrite(mosfetPin, HIGH);
            delay(pausa*3);
            break;
          case '/':
            delay(pausa*7);
            break;
          default:
            delay(pausa);
            break;  
        }
        digitalWrite(mosfetPin, LOW);
        delay(pausa);
      }
      startStop();
      code = "";
    }   

  }
  delay(10);
}

void startStop(){
  digitalWrite(mosfetPin, HIGH);
  delay(2000);
  digitalWrite(mosfetPin, LOW);
  delay(1000);
}

