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
TaskHandle_t Task1;
TaskHandle_t Task2;

uint32_t tsLastReport = 0;

const char *ssid = "afa2020_2.4Ghz@unifi";                          // afa2020_2.4Ghz@unifi , KOMPUTER, vivo1713
const char *pass = "vae585910";                                     // vae585910 , NIL, vae585910
String serverName = "http://192.168.1.9/oximeterserver/insert.php"; // check sebelum upload
String apiKeyValue = "oxytest";
String sensorname = "oxy1";
float BPM, SpO2;

// OLED
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 32 // OLED display height, in pixels 32
#define OLED_RESET -1    // Reset pin # (or -1 if sharing Arduino reset pin)

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET); // Declaring the display name (display)

// LED
// #define LED_pin4 4  // tentukan nama device pada pin
// #define LED_pin2 2
// #define LED_pin15 15
// #define LED_pin19 19
// #define LED_pin18 18
// #define LED_pin5 5

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

  xTaskCreatePinnedToCore(
      Task1code, /* Task function. */
      "Task1",   /* name of task. */
      10000,     /* Stack size of task */
      NULL,      /* parameter of the task */
      1,         /* priority of the task */
      &Task1,    /* Task handle to keep track of created task */
      0);        /* pin task to core 0 */
  delay(500);

  xTaskCreatePinnedToCore(
      Task2code, /* Task function. */
      "Task2",   /* name of task. */
      10000,     /* Stack size of task */
      NULL,      /* parameter of the task */
      1,         /* priority of the task */
      &Task2,    /* Task handle to keep track of created task */
      1);        /* pin task to core 0 */
  delay(500);

  // pinMode(LED_pin4, OUTPUT);  // declare pin samada input @ output
  // pinMode(LED_pin2, OUTPUT);
  // pinMode(LED_pin15, OUTPUT);
  // pinMode(LED_pin19, OUTPUT);
  // pinMode(LED_pin18, OUTPUT);
  // pinMode(LED_pin5, OUTPUT);

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

void Task1code(void *pvParameters)
{

  for (;;)
  {
    if (WiFi.status() == WL_CONNECTED)
    {

      Serial.print("Task1 running on core ");
      Serial.println(xPortGetCoreID());
      WiFiClient client;
      HTTPClient http;
      http.begin(client, serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      String httpRequestData = "api_key=" + apiKeyValue + "&bpm=" + String(BPM) + "&o2=" + String(SpO2) + "&sensorname=" + sensorname;
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
    delay(1000);
  }
}

void Task2code(void *pvParameters)
{

  for (;;)
  {
    // Make sure to call update as fast as possible
    pox.update();

    // Asynchronously dump heart rate and oxidation levels to the serial
    // For both, a value of 0 means "invalid"
    if (millis() - tsLastReport > REPORTING_PERIOD_MS)
    {
      Serial.print("loop() running on core ");
      Serial.println(xPortGetCoreID());

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

      // if (BPM < 60) {
      //   digitalWrite(LED_pin4, HIGH);  // LED MERAH on
      //   digitalWrite(LED_pin2, LOW);   // LED KUNING off
      //   digitalWrite(LED_pin15, LOW);  // LED HIJAU off
      // }
      // if (BPM > 100) {
      //   digitalWrite(LED_pin4, LOW);   // LED MERAH off
      //   digitalWrite(LED_pin2, HIGH);  // LED KUNING on
      //   digitalWrite(LED_pin15, LOW);  // LED HIJAU off
      // }
      // if (BPM > 60 && BPM < 100) {
      //   digitalWrite(LED_pin4, LOW);    // LED MERAH off
      //   digitalWrite(LED_pin2, LOW);    // LED KUNING off
      //   digitalWrite(LED_pin15, HIGH);  // LED HIJAU on
      // }

      // if (SpO2 > 94) {
      //   digitalWrite(LED_pin19, LOW);  // LED MERAH oFF
      //   digitalWrite(LED_pin18, LOW);  // LED KUNING oFF
      //   digitalWrite(LED_pin5, HIGH);  // LED HIJAU ON
      // }

      // if (SpO2 > 89 && SpO2 < 95) {
      //   digitalWrite(LED_pin19, LOW);   // LED MERAH oFF
      //   digitalWrite(LED_pin18, HIGH);  // LED KUNING ON
      //   digitalWrite(LED_pin5, LOW);    // LED HIJAU oFF
      // }

      // if (SpO2 < 90){

      //   digitalWrite(LED_pin19, HIGH);  // LED MERAH ON
      // digitalWrite(LED_pin18, LOW);     // LED KUNING oFF
      // digitalWrite(LED_pin5, LOW);      // LED HIJAU oFF
      // }

      tsLastReport = millis();
    }
  }
}

void loop()
{
}
