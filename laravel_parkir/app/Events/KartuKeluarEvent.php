<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KartuKeluarEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Properti publik ini akan otomatis dikirim sebagai data ke frontend.
     */
    public string $uid;
    public string $message;

    /**
     * Membuat instance event baru.
     */
    public function __construct(string $uid)
    {
        $this->uid = $uid;
        $this->message = "Kartu dengan UID {$uid} telah melakukan scan keluar.";
    }

    /**
     * Menentukan channel (saluran) tempat event ini akan disiarkan.
     * Anggap ini seperti nama stasiun radio publik.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('parkir-channel'),
        ];
    }

    /**
     * Menentukan nama event yang akan didengarkan oleh frontend.
     * Anggap ini seperti judul lagu yang diputar di stasiun radio.
     */
    public function broadcastAs(): string
    {
        return 'kartu.keluar';
    }
}
// ```
// **Poin Penting:**
// * `implements ShouldBroadcast`: Memberitahu Laravel bahwa Event ini harus disiarkan.
// * `public string $message;`: Data yang ingin kita kirim ke pop-up di frontend.
// * `broadcastOn()`: Nama channel kita adalah `parkir-channel`.
// * `broadcastAs()`: Nama event yang akan kita dengarkan di JavaScript adalah `kartu.keluar`.

