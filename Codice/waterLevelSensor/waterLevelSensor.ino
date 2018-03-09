
void setup(){
  Serial.begin(9600);     // Communication started with 9600 baud
  pinMode(3, OUTPUT);
}


void loop(){
  int sensor = analogRead(A1); // Incoming analog signal read and appointed sensor
  Serial.println(sensor);   //Wrote serial port
  if(sensor<200){
    digitalWrite(3, HIGH);
    delay(5000);
  }else{
    digitalWrite(3, LOW);
  }
}
