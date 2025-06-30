<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Masuk;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log; // <-- 1. Tambahkan use statement untuk Log

class ParkingTable extends Component
{
    
    use WithPagination;

//     public function mount(){
// Log::info("Masuk ke liveware refreshing parking table.php ");
//     }
    
    /**
     * Listener untuk event dari Pusher.
     * Pastikan string ini 100% cocok dengan file Event Anda.
     */
    #[On('echo:parking-updates,table.refreshed')]

    
    public function refreshTable()
    {
        // 2. Tambahkan log ini untuk debugging.
        // Jika Anda melihat pesan ini di laravel.log, berarti listener ini
        // berhasil dipanggil, dan masalahnya ada pada proses re-render Livewire.
        // Jika TIDAK MUNCUL, berarti ada masalah pada koneksi Echo atau string listener.
        Log::info('EVENT DITERIMA OLEH KOMPONEN LIVEWIRE! Memicu refresh...');
    }

    /**
     * Metode untuk me-render komponen.
     */
    public function render()
    {
        $kendaraan = Masuk::latest('waktu')->paginate(10);

        return view('livewire.parking-table', [
            'kendaraan' => $kendaraan,
        ]);
    }
}
