<?php
// app/Events/RefreshParkingTable.php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Pastikan class ini mengimplementasikan `ShouldBroadcast`
// Ini memberitahu Laravel bahwa event ini harus disiarkan.
class RefreshParkingTable implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * (Untuk kasus ini, kita tidak perlu mengirim data apa pun, jadi biarkan kosong)
     */
    public function __construct()
    {
        //
    }

    /**
     * Mendapatkan channel tempat event akan disiarkan.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Ini adalah nama "saluran radio" publik tempat kita akan menyiarkan.
        // Frontend harus mendengarkan di saluran dengan nama yang sama persis.
        Log::info('Masuk ke class event');
        return [
            new Channel('parking-updates')
        ];
    }

    /**
     * Nama event yang akan disiarkan.
     * Jika tidak didefinisikan, Laravel akan menggunakan nama class (RefreshParkingTable).
     * Lebih baik menentukannya secara eksplisit agar lebih rapi.
     */
    public function broadcastAs(): string
    {
        return 'table.refreshed';
    }
}
// ```

// #### **A. Cara Membuat File Event di Atas:**

// 1.  Buka terminal di direktori proyek Laravel Anda.
// 2.  Jalankan perintah `make:event` dari artisan:
//     ```bash
//     php artisan make:event RefreshParkingTable
//     ```
// 3.  Perintah ini akan membuat file baru di `app/Events/RefreshParkingTable.php`.
// 4.  Buka file tersebut dan **ganti seluruh isinya** dengan kode yang saya berikan di atas. Pastikan `implements ShouldBroadcast` sudah ada.

// #### **B. Mengirim Event dari Rute API Anda**

// Sekarang, kita perlu memicu atau "menyiarkan" event ini dari dalam rute API Anda setiap kali ada data yang berhasil disimpan.

// 1.  Buka file `routes/api.php`.
// 2.  Tambahkan `use App\Events\RefreshParkingTable;` di bagian atas file.
// 3.  Di dalam rute `/kartu/masuk` dan `/kartu/keluar`, tambahkan baris `broadcast(new RefreshParkingTable());` setelah data berhasil diproses.


// ```php