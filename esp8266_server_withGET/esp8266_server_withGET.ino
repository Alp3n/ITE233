
/*
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # 
# RFID MFRC522 / RC522 Library : https://github.com/miguelbalboa/rfid # 
#                                                                     # 
#                 Installation :                                      # 
# NodeMCU ESP8266/ESP12E    RFID MFRC522 / RC522                      #
#         D2/GPIO10 <---------->   SDA/SS                             #
#         D5        <---------->   SCK                                #
#         D7        <---------->   MOSI                               #
#         D6        <---------->   MISO                               #
#         GND       <---------->   GND                                #
#         D1/GPIO16 <---------->   RST                                #
#         3V/3V3    <---------->   3.3V                               #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# I2C OLED 126x64 Library: https://github.com/greiman/SSD1306Ascii    #
#                                                                     #
#         D1        <---------->   SCL                                #
#         D1        <---------->   SDA                                #
#         3V/3V3    <---------->   3.3V                               #
#         GND       <---------->   GND                                #
#                                                                     #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
*/

//----------------------------------------Include the NodeMCU ESP8266 library------------------------------------------//
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
//---------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Include the SPI and MFRC522 libraries----------------------------------------//
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10  //--> SDA / SS is connected to pinout D8
#define RST_PIN 16  //--> RST is connected to pinout D4
MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance.
//---------------------------------------------------------------------------------------------------------------------//

//------------------------------------------Include the I2C OLED libraries---------------------------------------------//
#include <Wire.h>
#include <SSD1306Ascii.h>
#include <SSD1306AsciiWire.h>

#define I2C_ADDRESS 0x3C
SSD1306AsciiWire oled;
//---------------------------------------------------------------------------------------------------------------------//


#define ON_Board_LED 2  //--> Defining an On Board LED, used for indicators when the process of connecting to a wifi router

//----------------------------------------SSID and Password of your WiFi router----------------------------------------//
const char* ssid = "Adamxd_2.4G";
const char* password = "0936078960";
//---------------------------------------------------------------------------------------------------------------------//

ESP8266WebServer server(80);  //--> Server on port 80

int readsuccess;
byte readcard[4];
char str[32] = "";
String strUID;
String balance;

String postUrl = "http://192.168.1.100/ite233/getUID.php";
String getUrl = "http://192.168.1.100/ite233/balanceContainer.php";

//-----------------------------------------------------SETUP----------------------------------------------------------//
void setup() {
  Serial.begin(115200); //--> Initialize serial communications with the PC
  SPI.begin();      //--> Init SPI bus
  mfrc522.PCD_Init(); //--> Init MFRC522 card

  delay(500);

  WiFi.begin(ssid, password); //--> Connect to your WiFi router
  Serial.println("");
    
  pinMode(ON_Board_LED,OUTPUT); 
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off Led On Board

  //-------------------------------------------Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //-----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  }
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off the On Board LED when it is connected to the wifi router.
  //------------------------------------------If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  Wire.begin();
  Wire.setClock(400000L);
  oled.begin(&Adafruit128x64, I2C_ADDRESS);
  oled.setFont(Arial14);
  oled.clear();
  
  Serial.println("Please tap a card or keychain to see the UID !");
  oled.println("Scanning...");
}
//-------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------LOOP----------------------------------------------------------//
void loop() {

  readsuccess = getid();
  
  if(readsuccess) {
    
    digitalWrite(ON_Board_LED, LOW);
    
    HTTPClient http;    //Declare object of class HTTPClient

    String UIDresultSend, postData;
    UIDresultSend = strUID;
   
    //Post Data
    postData = "UIDresult=" + UIDresultSend;
    
    http.begin(postUrl);  //Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header
    int postHttpCode = http.POST(postData);   //Send the request
    String payload = http.getString();    //Get the response payload
  
    Serial.println(UIDresultSend);
    Serial.println(postHttpCode);   //Print HTTP return code
    Serial.println(payload);    //Print request response payload

    // Oled display
    oled.clear();
    oled.println("ID:" + strUID);
    delay(5000);
    //Get Data
    http.begin(getUrl);
    int getHttpCode = http.GET();
    payload = http.getString();
    balance = payload;
    Serial.println(getHttpCode);   //Print HTTP return code
    Serial.println(balance);    //Print request response payload
    

    // Oled display
    if (balance.equals("")) { //GET request
      oled.println("\nNot registered");
      delay(3000);
    } else {
      oled.println("\nBalance: ");
      oled.println(balance + " THB");
//      delay(3000);

      String newBalance = balance;
      int delayNumber;
//      while(newBalance.equals(balance) || delayNumber == 6) {
//        for (delayNumber = 0; delayNumber < 7; delayNumber ++) {
//          int getHttpCode = http.GET();
//          newBalance = http.getString();
//        }
//      }
        for (delayNumber = 0; delayNumber < 7; delayNumber ++) {
          int getHttpCode = http.GET();
          newBalance = http.getString();
          delay(1000);
        }
      oled.clear();
      if (!newBalance.equals(balance)) {
        oled.println("New balance:\n" + newBalance);
        delay(4000);
      }
    }

    http.end();  //Close connection
    oled.clear();
    oled.println("Scanning...");
    
  digitalWrite(ON_Board_LED, HIGH);
  }
}
//-------------------------------------------------------------------------------------------------------------------//

//---------------------Function for reading and obtaining a UID from a card or keychain-----------------------------//
int getid() {
  if(!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if(!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }
 
  
  Serial.print("THE UID OF THE SCANNED CARD IS : ");
  
  for(int i=0;i<4;i++){
    readcard[i]=mfrc522.uid.uidByte[i]; //storing the UID of the tag in readcard
    array_to_string(readcard, 4, str);
    strUID = str;
  }
  mfrc522.PICC_HaltA();
  return 1;
}
//-------------------------------------------------------------------------------------------------------------------//

//-------------------Fucntion to change the result of reading an array UID into a string----------------------------//
void array_to_string(byte array[], unsigned int len, char buffer[]) {
    for (unsigned int i = 0; i < len; i++)
    {
        byte nib1 = (array[i] >> 4) & 0x0F;
        byte nib2 = (array[i] >> 0) & 0x0F;
        buffer[i*2+0] = nib1  < 0xA ? '0' + nib1  : 'A' + nib1  - 0xA;
        buffer[i*2+1] = nib2  < 0xA ? '0' + nib2  : 'A' + nib2  - 0xA;
    }
    buffer[len*2] = '\0';
}
//-------------------------------------------------------------------------------------------------------------------//
