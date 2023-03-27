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
#include <Adafruit_GFX.h> //OLED libraries
#include <Adafruit_SSD1306.h>
#include <Wire.h>
#include "MAX30100_PulseOximeter.h"
#include <WiFi.h>
#include <HTTPClient.h>
// #include <WiFiClient.h>
#define REPORTING_PERIOD_MS 1000

// PulseOximeter is the higher level interface to the sensor
// it offers:
//  * beat detection reporting
//  * heart rate calculation
//  * SpO2 (oxidation level) calculation
PulseOximeter pox;

uint32_t tsLastReport = 0;
const char *ssid = "afa2020_2.4Ghz@unifi";                          // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";                                     // vae585910 , NIL, vae585910
String serverName = "http://192.168.1.10/oximeterserver/insert.php"; // check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";
float BPM, SpO2;

// OLED
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 32 // OLED display height, in pixels 32
#define OLED_RESET -1    // Reset pin # (or -1 if sharing Arduino reset pin)

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET); // Declaring the display name (display)

// LED
// #define LED_pin7 D7 // tentukan nama device pada pin
// #define LED_pin6 D6
// #define LED_pin5 D5
// #define LED_pin4 D4
// #define LED_pin3 D3
// #define LED_pin8 D8
void setup()
{
  Serial.begin(115200);
  pinMode(16, OUTPUT);
  delay(100);

  Serial.println("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, pass);
  Serial.println("Connecting");

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // Initialize the PulseOximeter instance
  // Failures are generally due to an improper I2C wiring, missing power supply
  // or wrong target chip

  // OLED
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C); // Start the OLED display
  display.display();
  delay(3000);

  // pinMode(LED_pin7, OUTPUT); // declare pin samada input @ output
  // pinMode(LED_pin6, OUTPUT);
  // pinMode(LED_pin5, OUTPUT);
  // pinMode(LED_pin4, OUTPUT);
  // pinMode(LED_pin3, OUTPUT);
  // pinMode(LED_pin8, OUTPUT);

  Serial.print("Initializing pulse oximeter..");
  if (!pox.begin())
  {
    Serial.println("FAILED");
    for (;;)
      ;
  }
  else
  {
    Serial.println("SUCCESS");
  }
}

void loop()
{
  // Make sure to call update as fast as possible
  pox.update();

  // Asynchronously dump heart rate and oxidation levels to the serial
  // For both, a value of 0 means "invalid"
  if (millis() - tsLastReport > REPORTING_PERIOD_MS)
  {

    BPM = pox.getHeartRate();
    SpO2 = pox.getSpO2();

    display.clearDisplay(); // Clear the display
    display.setTextSize(1); // Near it display the average BPM you can display the BPM if you want
    display.setTextColor(WHITE);
    display.setCursor(30, 0);
    display.println("BPM");
    display.setCursor(30, 8);
    display.println(BPM);
    display.setCursor(90, 0); // 80,0
    display.println("SpO2");
    display.setCursor(90, 8); // 82,18
    display.println(SpO2);
    display.display();

    Serial.print("BPM: ");
    Serial.println(BPM);

    Serial.print("SpO2: ");
    Serial.print(SpO2);
    Serial.println("%");

    Serial.println("*********************************");
    Serial.println();

    // if (BPM < 60)
    // {
    //   digitalWrite(LED_pin5, HIGH); // LED MERAH on
    //   digitalWrite(LED_pin6, LOW);  // LED KUNING on
    //   digitalWrite(LED_pin7, LOW);  // LED HIJAU on
    // }
    // if (BPM > 100)
    // {
    //   digitalWrite(LED_pin5, LOW);  // LED MERAH on
    //   digitalWrite(LED_pin6, HIGH); // LED KUNING on
    //   digitalWrite(LED_pin7, LOW);  // LED HIJAU on
    // }
    // if (BPM > 60 && BPM < 100)
    // {
    //   digitalWrite(LED_pin5, LOW);  // LED MERAH on
    //   digitalWrite(LED_pin6, LOW);  // LED KUNING on
    //   digitalWrite(LED_pin7, HIGH); // LED HIJAU on
    // }

    // if (SpO2 > 94)
    // {
    //   digitalWrite(LED_pin3, LOW);  // LED MERAH oFF
    //   digitalWrite(LED_pin8, LOW);  // LED KUNING oFF
    //   digitalWrite(LED_pin4, HIGH); // LED HIJAU ON
    // }

    // if (SpO2 > 89 && SpO2 < 95)
    // {
    //   digitalWrite(LED_pin3, LOW);  // LED MERAH oFF
    //   digitalWrite(LED_pin8, HIGH); // LED KUNING ON
    //   digitalWrite(LED_pin4, LOW);  // LED HIJAU oFF
    // }

    // if (SpO2 < 90)
    // {
    //   digitalWrite(LED_pin3, HIGH); // LED MERAH ON
    //   digitalWrite(LED_pin8, LOW);  // LED KUNING oFF
    //   digitalWrite(LED_pin4, LOW);  // LED HIJAU oFF
    // }

    if (WiFi.status() == WL_CONNECTED)
    {
      Serial.println("still connected");

      if (millis() - tsLastReport > 10000)
      {
        WiFiClient client;
        HTTPClient http;
        http.begin(client, serverName);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        String httpRequestData = "api_key=" + apiKeyValue + "&bpm=" + String(pox.getHeartRate()) + "&o2=" + String(pox.getSpO2()) + "&sensorname=" + sensorname;
        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);
        int httpResponseCode = http.POST(httpRequestData);
        String payload = http.getString();
        Serial.println("PAYLOAD");
        Serial.println(payload);
        if (httpResponseCode > 0)
        {
          Serial.print("HTTP Response code: ");
          Serial.println(httpResponseCode);
        }
        else
        {
          Serial.print("Error code: ");
          Serial.println(httpResponseCode);
        }
        http.end();
      }
    }

    tsLastReport = millis();
  }
}
