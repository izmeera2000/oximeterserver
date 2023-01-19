#include <Wire.h>
#include "MAX30100_PulseOximeter.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#define REPORTING_PERIOD_MS 1000

// Create a PulseOximeter object
PulseOximeter pox;

// Time at which the last beat occurred
uint32_t tsLastReport = 0;

// Replace with your network credentials
const char *ssid = "afa2020_2.4Ghz@unifi";  // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";             // vae585910 , NIL, vae585910
const char *serverName = "http://192.168.1.7/oximeterserver/insert.php"; //check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";


void setup() {
  Serial.begin(115200);

  Serial.print("Initializing pulse oximeter..");

  // Initialize sensor
  if (!pox.begin()) {
    Serial.println("FAILED");
    for (;;)
      ;
  } else {
    Serial.println("SUCCESS");
  }

  WiFi.begin(ssid, password);

  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // Configure sensor to use 7.6mA for LED drive
  pox.setIRLedCurrent(MAX30100_LED_CURR_7_6MA);
}

void loop() {
  // Read from the sensor
  pox.update();

  // Grab the updated heart rate and SpO2 levels
  if (millis() - tsLastReport > REPORTING_PERIOD_MS) {

    int bpm = pox.getHeartRate();
    int spo = pox.getSpO2();

    Serial.print("Heart rate:");
    Serial.print(bpm);
    Serial.print("bpm / SpO2:");
    Serial.print(spo);
    Serial.println("%");


    if (WiFi.status() == WL_CONNECTED) {
      WiFiClient client;
      HTTPClient http;

      // Your Domain name with URL path or IP address with path
      http.begin(client, serverName);

      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      String httpRequestData = "api_key=" + apiKeyValue + "&sensorname=" + sensorname + "&bpm=" + String(bpm) + "&o2=" + String(spo) + "";
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

    tsLastReport = millis();
  }
}