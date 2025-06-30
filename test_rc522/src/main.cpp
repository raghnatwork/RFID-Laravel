#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

#define RST_PIN D0
#define SS_PIN  D4

const char* ssid = "Hendro Kos 4";
const char* password = "koshendroarea4";
const char* serverUrl = "http://192.168.1.106:8000/kartu/masuk"; // Pastikan IP dan port sesuai

MFRC522 mfrc522(SS_PIN, RST_PIN);
WiFiClient client;

// === Fungsi sendUID diletakkan di atas ===
void sendUID(String uid) {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, serverUrl); // ← sesuai format baru
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String data = "uid=" + uid;
    int httpCode = http.POST(data);

    if (httpCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);
    } else {
      Serial.println("Failed to connect. Error: " + http.errorToString(httpCode));
    }

    http.end();
  }
}


void setup() {
  Serial.begin(9600);
  SPI.begin();
  mfrc522.PCD_Init();

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi connected");
  Serial.println(WiFi.localIP());
}

void loop() {
  if (!mfrc522.PICC_IsNewCardPresent()) return;
  if (!mfrc522.PICC_ReadCardSerial()) return;

  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    if (mfrc522.uid.uidByte[i] < 0x10) uid += "0";
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }

  Serial.println("UID: " + uid);
  sendUID(uid);

  mfrc522.PICC_HaltA();
  delay(1000);
}