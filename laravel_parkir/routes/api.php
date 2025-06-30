<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Model Parkir
use App\Models\Masuk;
use App\Models\DetailParkir;


// Untuk timestamp
use Illuminate\Support\Carbon;

// Rute untuk parkir masuk
Route::post('/kartu/masuk', function (Request $request) {
    $uid = $request->input('uid');

    if (empty($uid)) {
        Log::warning('Permintaan UID masuk kosong diterima.');
        return response()->json(['kode' => 'masuk', 'status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
    }

    try {

        // Menambahkan id dan waktu saat parkir masuk
        $masukEntry = Masuk::updateOrCreate(
            ['id_kendaraan' => $uid],
            ['waktu' => Carbon::now()]
        );
        
        // Respon yang akan diberikan ke nodemcu
        return response()->json([
            'kode' => 'masuk',
            'status' => 'success',
            'message' => 'UID diterima dan data waktu diperbarui/disimpan',
            'data' => [
                'uid' => $masukEntry->id_kendaraan,
                'time' => $masukEntry->waktu->toDateTimeString(),
                'action' => $masukEntry->wasRecentlyCreated ? 'created' : "updated"
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('Gagal memproses data masuk UID: ' . $uid . ' - ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan server'], 500);
    }
});


// Rute untuk parkir keluar
Route::post('/kartu/keluar', function (Request $request) {
    $uid = $request->input('uid');

    if (empty($uid)) {
        Log::warning('Permintaan UID keluar kosong diterima.');
        return response()->json(['status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
    }

    try {
        // Mencari id_kendaraan di tabel masuk berdasarkan id_kendaraan
        $masukEntry = Masuk::where('id_kendaraan', $uid)->first();

        if (!$masukEntry) {
            Log::warning('UID ' . $uid . ' tidak ditemukan di tabel MASUK saat mencoba KELUAR.');
            return response()->json(['status' => 'error', 'message' => 'Kendaraan ini tidak tercatat masuk'], 404);
        }

        // Manipulasi waktu agar mudah diolah
        $waktuMasuk = Carbon::parse($masukEntry->waktu);
        $waktuKeluar = Carbon::now();

        // $durasiMenit = abs($waktuKeluar->diffInMinutes($waktuMasuk));
        // $durasiJam = ceil($durasiMenit / 60);
        // if ($durasiJam == 0) $durasiJam = 1; // Minimal dihitung 1 jam
        // $tarif = $durasiJam * 2000;


        // Rumus untuk menentukan tarif parkir dan durasi parkir
        $durasiDetik = round(abs($waktuKeluar->diffInSeconds($waktuMasuk))); 
        $durasiMenit = ceil($durasiDetik / 60); 
        $durasiJam = ceil($durasiMenit / 60); 
        if ($durasiJam == 0) $durasiJam = 1; 
        $tarif = $durasiJam * 2000;


        // Memasukan data ke tabel detail_parkir
        $detailParkir = DetailParkir::create([
            'id_kendaraan' => $uid,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => $waktuKeluar,
            'durasi' => $durasiDetik,
            'tarif' => $tarif,
        ]);

        // Hapus id kendaraaan yang sudah keluar dari tabel masuk
        $masukEntry->delete();
       
        // Respon yang akan diberikan ke nodemcu
        return response()->json([
            'kode' => 'keluar',
            'status' => 'success',
            'message' => 'Kendaraan berhasil keluar',
            'data' => [
                'uid' => $uid,
                'waktu_masuk' => $waktuMasuk->toDateTimeString(),
                'waktu_keluar' => $waktuKeluar->toDateTimeString(),
                'durasi_menit' => $durasiMenit,
                'tarif' => $tarif
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('Gagal memproses data KELUAR UID: ' . $uid . ' - ' . $e->getMessage());
        return response()->json(['status' => 'error','message' => 'Terjadi kesalahan server saat proses keluar'], 500);
    }
});