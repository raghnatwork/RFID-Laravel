Cara kerja aplikasi: Kartu RFID nantinya ditempelkan ke RFID, kemudian sistem akan mencatat ke database di tabel masuk bahwa terdapat kendaraan masuk.
Ketika keluar sistem akan mencari nomor plat atau id kendaraan pada tabel masuk, lalu menambahkan data nomor plat, waktu masuk, waktu keluar, dan
durasi parkir dalam detik ke tabel riwayat parkir, setelahnya sistem akan menghapus nomor plat atau id kendaraan pada tabel masuk jika data sudah berhasil di 
catat di tabel riwayat parkir

Framework : Laravel 12, PlatformIO
Library Laravel: 
-tailwind
-flowbite

Library PlatformIO:
-miguelbalboa/MFRC522@^1.4.12
-bblanchon/ArduinoJson@^7.4.1


![image](https://github.com/user-attachments/assets/cb24eafe-4f41-45d4-a911-f02ea6e13c38)
![image](https://github.com/user-attachments/assets/b03405f8-7e72-4618-8528-5bcfb8042b0b)
![image](https://github.com/user-attachments/assets/20f20a91-a1db-4664-a22f-df0039189dcc)
![image](https://github.com/user-attachments/assets/ece91127-db91-4f18-8639-75d6ddef5733)
![image](https://github.com/user-attachments/assets/bc2469cb-f878-4840-8764-8164f3d9fe17)

