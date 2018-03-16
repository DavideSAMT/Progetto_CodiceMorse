int X;
#define emitter 5
#define detector 6
#define tester 8
int timer1_counter;
// VARIABILI MORSE VALORI STANDARD
// *******************************
int dot = 1;
int symbolSpace = dot;
int dash = dot * 3;
int letterSpace = dash;
int wordSpace = dot * 7;
// *******************************
int timeOfProtocol = 10; // MILLI_SECONDI
void setup() {
  pinMode(emitter, OUTPUT);
  pinMode(detector, INPUT);
  Serial.begin(9600);
  
  //inizialize Timer
  noInterrupts();           // Disabilito tutti gli interrupts
  TCCR1A = 0;               // TCCR1A, costante già esistente in Arduino
  TCCR1B = 0;               // TCCR1B, costante già esistente in Arduino
  timer1_counter = 65534;   // timer1_counter, variabile che rappresenta la frequenza
  TCNT1 = timer1_counter;   // TCNT1, costante già esistente in Arduino
  TCCR1B |= (1 << CS12);
  TIMSK1 |= (1 << TOIE1);
  interrupts();             // Riattivo tutti gli interrupts
}
// Frequenza dell'emitter
bool frequencyE;
// Frequenza del detector
bool frequencyD;
ISR(TIMER1_OVF_vect) {
  TCNT1 = timer1_counter;
  // Imposto la frequenza dell'emitter IR
  digitalWrite(emitter, digitalRead(emitter) ^ 1);
  // EMITTER FREQUENCY
  frequencyE = (digitalRead(emitter) ^ 1);
  // DETECTOR FREQUENCY
  frequencyD = digitalRead(detector);
}
String words; // Parole 
// #####################################################################################################################################################################################
// METODO PRINCIPALE
// #####################################################################################################################################################################################
void loop() {
  Serial.println("INIZIO");
  protocollo();
}
// #####################################################################################################################################################################################
// Metodo che traduce il messaggio in codice morse ricevuto in una stringa in italiano
// #####################################################################################################################################################################################
void translate(String str[]) {
  String result = "";
  String morse[] = {
                    ".-", "-...", "-.-.", "-..", ".", "..-.", "--.", "....", "..", 
                    ".---", "-.-", ".-..", "--", "-.", "---", ".--.", "--.-", ".-.", 
                    "...", "-", "..-", "...-", ".--", "-..-", "-.--", "--..",".----",
                    "..---","...--","....-",".....","-....","--...","---..","----.",
                    "-----", "/"
                    };
  char alfa[]={
               'A','B','C','D','E','F','G','H','I','J','K','L','M','N',
               'O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2',
               '3','4','5','6','7','8','9','0',' '
               };
  for (int i = 0; i < 255; i++) {
    for(int j = 0; j < 37; j++) {
      if(str[i] == morse[j]) {
        result += alfa[j];
      }
    }
  }
  return result; // STAMPA IL RISULTATO IN ITALIANO SUL LCD
}
// #####################################################################################################################################################################################
// Metodo per l'attesa del messaggio dall'Arduino Ethernet
// #####################################################################################################################################################################################
void protocollo () { 
  Serial.println("INIZIO PROTOCOLLO");
  bool esc = true;
  long timeOld = millis();
  long timeNew = NULL;
  bool readDetector = NULL;
  while(esc) {
    //Serial.println(digitalRead(6));
    if (digitalRead(6) == true) { // Passa l'acqua 
      while(true) {
        Serial.println(digitalRead(6)); // DA NON CANCELLARE O COMMENTARE !!!!!
        if (digitalRead(6) == false) { // Non passa più l'acqua, interrompo il loop
          timeNew = (millis() - timeOld);
          esc = false;
          break;
        }
      }
    }
      if (timeNew >= timeOfProtocol) {
        Serial.println("PROTOCOLLO ESEGUITO");
        ascoltoMorse();
      } 
  }
}
// #####################################################################################################################################################################################
// Metodo che attende il messaggio dall'elettrovalvola e lo memorizza
// #####################################################################################################################################################################################
void ascoltoMorse() {
  Serial.println("IN ASCOLTO..");
  //###-VARIABILI-##############################################################
  String character = "";              // CARATTERE ALFABETICO ESPRESSO IN MORSE
  String words[255];                  // CARATTERI DA TRADURRE
  int index = 0;                      // INDICE PER L'ARRAY WORDS
  int drop = 0;                       // COUNTER DELLE GOCCE E DELLE PAUSE
  int oldCheck = 50;                  // VECCHIO VALORE
  int newCheck;                       // NUOVO VALORE
  //############################################################################
  while(true) {
    if (digitalRead(6) == true) {                           // SE C'È ACQUA INIZIA
      while(true){
        if (digitalRead(6)) newCheck = 1;                   // VALORE CORRENTE
        else newCheck = 0;
        if ((newCheck != oldCheck) && (oldCheck != 50)){
          if (oldCheck == 1) Serial.print("GOCCIA: ");
          else if (oldCheck == 0) Serial.print("PAUSA: ");
          Serial.println(drop);
          if (oldCheck == 1) {                              // SE IL VALORE ERA ACQUA
            if (drop >= 0 && drop < 50) {
              Serial.println("DOT");
              character +=".";
            }
            else if (drop >= 50 && drop < 150) {
              Serial.println("DASH");
              character +="-";
            }
            else {
              Serial.println("END MESSAGE");
              translate(words);                            // QUANDO IL MESSAGGIO FINISCE FACCIO LA TRADUZIONE
            }
          }
          else {                                           // SE IL VALORE ERA PAUSA
            if (drop >= 0 && drop < 50) {
              // NIENTE
            }
            else if (drop >= 50 && drop < 150) {
              Serial.println("CHAR PAUSE");
              words[index] = character;
              index++;
            }
            else {
              Serial.println("WORD PAUSE");
              words[index] = " ";
              index++;
            }
          }
          drop = 0;
        }
        drop++;
        oldCheck = newCheck;
        delay(10);
      }
    }
  }
}
