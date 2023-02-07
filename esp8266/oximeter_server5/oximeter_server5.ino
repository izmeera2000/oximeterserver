//HEART RATE AND OXYGEN SATURATION CLOUD STORAGE BASED FOR REMOTE PATIENT
//blynk akaun berbayar   uname : 29221097@adtectaiping.edu.my
//                       pwd :adtectaiping2022

// #define BLYNK_TEMPLATE_ID "TMPLHQPlWoZS"
// #define BLYNK_DEVICE_NAME "REMOTE PATIENT MONITORING SYSTEM"
// #define BLYNK_AUTH_TOKEN "OOHrk_fEv6ftdQW4Y6mdqFDUSMf4QEP6"

#define REPORTING_PERIOD_MS 1000

#include <Adafruit_GFX.h>  //OLED libraries
#include <Adafruit_SSD1306.h>
#include <Wire.h>
#include "MAX30100_PulseOximeter.h"
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ESP8266WiFi.h>  // wifi
// #include <Blynk.h>
#include <TinyGPS++.h>
#include <SoftwareSerial.h>
// #include <BlynkSimpleEsp8266.h>

// PulseOximeter is the higher level interface to the sensor
// it offers:
//  * heart rate calculation
//  * SpO2 (oxidation level) calculation
PulseOximeter pox;

uint32_t tsLastReport = 0;

//wifi
const char *ssid = "afa2020_2.4Ghz@unifi";                           // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";                                      // vae585910 , NIL, vae585910
String serverName = "http://192.168.1.7/oximeterserver/insert.php";  //check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";




//gunakan ip untuk local server



//TinyGPSPlus gps;
//SoftwareSerial SerialGPS(4, 5); //GPIO 4 & 5
// #define BLYNK_PRINT Serial

float Latitude, Longitude;
int bpm, spo;

//OLED
#define SCREEN_WIDTH 128  // OLED display width, in pixels
#define SCREEN_HEIGHT 32  // OLED display height, in pixels 32
#define OLED_RESET -1     // Reset pin # (or -1 if sharing Arduino reset pin)

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);  //Declaring the display name (display)

//LED
#define LED_pin7 D7  // tentukan nama device pada pin
#define LED_pin6 D6
#define LED_pin5 D5
#define LED_pin4 D4
#define LED_pin3 D3
#define LED_pin8 D8




void setup() {
  Serial.begin(115200);
  //  SerialGPS.begin(9600);
  // Blynk.begin(auth, ssid, pass);

  //Wifi connection
  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED) {
    delay(200);
    Serial.print("..");
  }
  Serial.println();
  Serial.println("Congrats... NodeMCU is connected!");
  Serial.println(WiFi.localIP());
  // dht.begin();


  //OLED
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  //Start the OLED display
  display.display();
  delay(3000);
  //asalnya
  Serial.print("Initializing pulse oximeter..");

  // Initialize the PulseOximeter instance
  // Failures are generally due to an improper I2C wiring, missing power supply
  // or wrong target chip
  if (!pox.begin()) {
    Serial.println("FAILED");
    for (;;)
      ;
  } else
    Serial.println("SUCCESS");
  // {
  //   // timer.setInterval(3000L, timer1);
  // }
  //LED
  pinMode(LED_pin7, OUTPUT);  // declare pin samada input @ output
  pinMode(LED_pin6, OUTPUT);
  pinMode(LED_pin5, OUTPUT);
  pinMode(LED_pin4, OUTPUT);
  pinMode(LED_pin3, OUTPUT);
  pinMode(LED_pin8, OUTPUT);
}

void loop() {
  // Make sure to call update as fast as possible
  pox.update();
  // timer.run();
  // Blynk.run();


  // Asynchronously dump heart rate and oxidation levels to the serial
  // For both, a value of 0 means "invalid"
  if (millis() - tsLastReport > REPORTING_PERIOD_MS) {

    tsLastReport = millis();

    display.clearDisplay();  //Clear the display
    display.setTextSize(1);  //Near it display the average BPM you can display the BPM if you want
    display.setTextColor(WHITE);
    display.setCursor(30, 0);
    display.println("BPM");
    display.setCursor(30, 8);
    display.println(bpm);
    display.setCursor(90, 0);  //80,0
    display.println("SpO2");
    display.setCursor(90, 8);  // 82,18
    display.println(spo);
    display.setCursor(0, 16);  //80,0
    display.println("Lat   :");
    display.setCursor(0, 24);  //80,0
    display.println("Long  :");
    display.display();

    Serial.print("Heart rate:");
    Serial.print(pox.getHeartRate());
    Serial.print("bpm    SpO2:");  //"bpm / SpO2:"
    Serial.print(pox.getSpO2());
    Serial.println("%");


    if (pox.getHeartRate() < 60) {
      digitalWrite(LED_pin5, HIGH);  //LED MERAH on
      digitalWrite(LED_pin7, LOW);   //LED HIJAU on
      digitalWrite(LED_pin6, LOW);   //LED KUNING on
    }
    if (pox.getHeartRate() > 100) {
      digitalWrite(LED_pin6, HIGH);  //LED KUNING on
      digitalWrite(LED_pin5, LOW);   //LED MERAH on
      digitalWrite(LED_pin7, LOW);   //LED HIJAU on
    }
    if (pox.getHeartRate() > 60 && pox.getHeartRate() < 100) {
      digitalWrite(LED_pin7, HIGH);  //LED HIJAU on
      digitalWrite(LED_pin5, LOW);   //LED MERAH on
      digitalWrite(LED_pin6, LOW);   //LED KUNING on
    }


    if (pox.getSpO2() > 94) {
      digitalWrite(LED_pin3, LOW);   //LED MERAH oFF
      digitalWrite(LED_pin4, HIGH);  //LED HIJAU ON
      digitalWrite(LED_pin8, LOW);   //LED KUNING oFF
    }

    if (pox.getSpO2() > 89 && pox.getSpO2() < 95) {
      digitalWrite(LED_pin3, LOW);   //LED MERAH oFF
      digitalWrite(LED_pin4, LOW);   //LED HIJAU oFF
      digitalWrite(LED_pin8, HIGH);  //LED KUNING ON
    }

    if (pox.getSpO2() < 90) {
      digitalWrite(LED_pin3, HIGH);  //LED MERAH ON
      digitalWrite(LED_pin4, LOW);   //LED HIJAU oFF
      digitalWrite(LED_pin8, LOW);   //LED KUNING oFF
    }

    {
      bpm = pox.getHeartRate();
      spo = pox.getSpO2();
      // Blynk.virtualWrite(V5, bpm);
      // Blynk.virtualWrite(V6, spo);

      if (WiFi.status() == WL_CONNECTED) {
        WiFiClient client;
        HTTPClient http;

        // Your Domain name with URL path or IP address with path
        http.begin(client, serverName);

        // Specify content-type header
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        String httpRequestData = "api_key=" + apiKeyValue + "&bpm=" + String(pox.getHeartRate()) + "&o2=" + String(pox.getSpO2()) + "";
        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);

        int httpResponseCode = http.POST(httpRequestData);


        if (httpResponseCode > 0) {
          Serial.print("HTTP Response code: ");
          Serial.println(httpResponseCode);
        } else {
          Serial.print("Error code: ");
          Serial.println(httpResponseCode);
        }
        // Free resources
        http.end();
      } else {
        Serial.println("WiFi Disconnected");
      }
    }
  }
}