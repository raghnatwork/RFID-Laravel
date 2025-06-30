<?php

namespace App\Http\Controllers;

// (1) Import semua class yang dibutuhkan
use Illuminate\Http\Request;
use App\Events\KartuKeluarEvent; // Event yang akan kita tembakkan
use App\Models\DetailParkir;     // Model untuk berinteraksi dengan tabel database

class ParkirController extends Controller
{
    /**
     * Method ini akan menerima request POST dari NodeMCU.
     */
    public function kartuKeluar(Request $request)
    {
        // (2) Validasi request dari NodeMCU untuk memastikan ada data 'uid' yang dikirim
        $validated = $request->validate([
            'uid' => 'required|string|max:255',
        ]);

        $uid = $validated['uid'];

        try {
            // (3) Simpan data ke database
            // Sesuaikan nama kolom ('uid_kartu', 'waktu_keluar') dengan struktur tabel Anda
            DetailParkir::create([
                'uid_kartu' => $uid,
                'waktu_keluar' => now(), // 'now()' akan otomatis mengisi dengan waktu saat ini
            ]);

            // (4) Tembakkan event ke Pusher! Ini adalah inti dari fitur real-time kita.
            event(new KartuKeluarEvent($uid));

            // (5) Beri respons sukses ke NodeMCU dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data received and event broadcasted'
            ], 200);

        } catch (\Exception $e) {
            // (6) Blok catch untuk menangani jika ada error saat proses simpan atau lainnya
            // Anda bisa juga mencatat error ini ke log untuk dianalisa nanti
            // Log::error($e->getMessage()); 
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process request'
            ], 500);
        }
    }
}

