<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masuk extends Model
{
    use HasFactory;

    // Memberi tahu Laravel bahwa nama tabelnya adalah 'masuk' (bukan 'masuks')
    protected $table = 'masuk';

    // Menentukan primary key adalah 'id' (yang akan menyimpan UID dari RFID)
    protected $primaryKey = 'id_kendaraan';

    // Menentukan bahwa primary key TIDAK auto-incrementing
    public $incrementing = false;

    // Menentukan tipe data primary key adalah string
    protected $keyType = 'string';

    // Memberi tahu Laravel bahwa kita TIDAK menggunakan kolom created_at dan updated_at standar.
    // Kita hanya punya kolom 'waktu'.
    public $timestamps = false; // <-- PENTING ini!

    // Mendefinisikan kolom yang bisa diisi secara massal
    protected $fillable = [
        'id_kendaraan',   // Kolom 'id' akan diisi dengan UID dari RFID
        'waktu',
    ];

    protected $casts = [
        'waktu'  => 'datetime',
    ];
}
