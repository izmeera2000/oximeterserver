#include <Wire.h>
#include <MAX30100_PulseOximeter.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#define REPORTING_PERIOD_MS 1000

uint32_t tsLastReport = 0;
const char *ssid = "afa2020_2.4Ghz@unifi";                               // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";                                          // vae585910 , NIL, vae585910
const char *serverName = "http://192.168.1.7/oximeterserver/insert.php"; // check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";

PulseOximeter pox;
WiFiClient client;

void setup()
{
  Serial.begin(115200);
  Wire.begin();

  if (!pox.begin())
  {
    Serial.println("MAX30100 was not found.");
    while (1)
      ;
  }

  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop()
{
  pox.update();

  if (millis() - tsLastReport > REPORTING_PERIOD_MS)
  {
    float heartRate = pox.getHeartRate();
    float oxygenSaturation = pox.getSpO2();
    Serial.print("Heart Rate: ");
    Serial.print(heartRate);
    Serial.print(", Oxygen Saturation: ");
    Serial.println(oxygenSaturation);
    if (WiFi.status() == WL_CONNECTED)
    {
      HTTPClient http;
      http.begin(client, serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      String data = "heart_rate=" + String(heartRate) + "&oxygen_saturation=" + String(oxygenSaturation);
      int httpCode = http.POST(data);
      if (httpCode > 0)
      {
        Serial.printf("[HTTP] POST... code: %d\n", httpCode);
        if (httpCode == HTTP_CODE_OK)
        {
          String response = http.getString();
          Serial.println(response);
        }
      }
      else
      {
        Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }
      http.end();
    }
  }

  tsLastReport = millis();
}
