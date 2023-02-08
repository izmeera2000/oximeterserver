/*
Arduino-MAX30100 oximetry / heart rate integrated sensor library
Copyright (C) 2016  OXullo Intersecans <x@brainrapers.org>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
#include <Adafruit_GFX.h>  //OLED libraries
#include <Adafruit_SSD1306.h>
#include <Wire.h>
#include "MAX30100_PulseOximeter.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
// #include <WiFiClient.h>
#define REPORTING_PERIOD_MS 1000

// PulseOximeter is the higher level interface to the sensor
// it offers:
//  * beat detection reporting
//  * heart rate calculation
//  * SpO2 (oxidation level) calculation
PulseOximeter pox;

uint32_t tsLastReport = 0;
const char *ssid = "afa2020_2.4Ghz@unifi";                           // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";                                      // vae585910 , NIL, vae585910
String serverName = "http://192.168.1.7/oximeterserver/insert.php";  //check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";
float BPM, SpO2;

//OLED
#define SCREEN_WIDTH 128                                                   // OLED display width, in pixels
#define SCREEN_HEIGHT 32                                                   // OLED display height, in pixels 32
#define OLED_RESET -1                                                      // Reset pin # (or -1 if sharing Arduino reset pin)
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);  //Declaring the display name (display)

// Callback (registered below) fired when a pulse is detected
void onBeatDetected() {
  Serial.println("Beat!");
}

void setup() {
  Serial.begin(115200);
  delay(100);


  WiFi.begin(ssid, pass);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  // Initialize the PulseOximeter instance
  // Failures are generally due to an improper I2C wiring, missing power supply
  // or wrong target chip
  Serial.print("Initializing pulse oximeter..");
  if (!pox.begin()) {
    Serial.println("FAILED");
    for (;;)
      ;
  } else {
    Serial.println("SUCCESS");
  }


  //OLED
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  //Start the OLED display
  display.display();
  delay(3000);
  //asalnya
  // The default current for the IR LED is 50mA and it could be changed
  //   by uncommenting the following line. Check MAX30100_Registers.h for all the
  //   available options.
  // pox.setIRLedCurrent(MAX30100_LED_CURR_7_6MA);

  // Register a callback for the beat detection
  // pox.setOnBeatDetectedCallback(onBeatDetected);
}

void loop() {
  // Make sure to call update as fast as possible
  pox.update();

  // Asynchronously dump heart rate and oxidation levels to the serial
  // For both, a value of 0 means "invalid"
  if (millis() - tsLastReport > REPORTING_PERIOD_MS) {

    
    BPM = pox.getHeartRate();
    SpO2 = pox.getSpO2();

    display.clearDisplay();  //Clear the display
    display.setTextSize(1);  //Near it display the average BPM you can display the BPM if you want
    display.setTextColor(WHITE);
    display.setCursor(30, 0);
    display.println("BPM");
    display.setCursor(30, 8);
    display.println(BPM);
    display.setCursor(90, 0);  //80,0
    display.println("SpO2");
    display.setCursor(90, 8);  // 82,18
    display.println(SpO2);

    Serial.print("Heart rate:");
    Serial.print(BPM);
    Serial.print("bpm / SpO2:");
    Serial.print(SpO2);
    Serial.println("%");

    tsLastReport = millis();
  }
}