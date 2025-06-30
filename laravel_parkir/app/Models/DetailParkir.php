<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // <--- TAMBAHKAN BARIS INI

class DetailParkir extends Model
{
    use HasFactory;

    protected $table = 'detail_parkir';
    public $timestamps = false;
    
    protected $fillable = [
        'id_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'durasi',
        'tarif',
    ];

    // Accessor untuk mendapatkan durasi dalam format HH:MM:SS
    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $totalSeconds = $attributes['durasi']; // Ambil dari kolom 'durasi' yang disimpan dalam detik

                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;

                // Menggunakan sprintf untuk memformat dengan leading zero (misal 01:02:03)
                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            },
        );
    }

    /**
     * Mengubah kolom waktu menjadi objek Carbon secara otomatis.
     */
    protected $casts = [
        'waktu_masuk'  => 'datetime',
        'waktu_keluar' => 'datetime',
        'tarif'        => 'integer', // Contoh lain jika tarif disimpan sbg string
        'durasi'       => 'integer', // Contoh lain jika durasi disimpan sbg string
    ];
}