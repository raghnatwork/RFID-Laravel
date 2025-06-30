<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Dasboard
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Model dan Controller Parkir
use App\Models\Masuk;
use App\Models\DetailParkir;
// use App\Events\RefreshParkingTable;

// Untuk timestamp
use Illuminate\Support\Carbon;

// Rute untuk menerima data kartu dari NodeMCU
Route::post('/kartu/masuk', function (Request $request) {
    $uid = $request->input('uid');

    if (empty($uid)) {
        Log::warning('Permintaan UID masuk kosong diterima.');
        return response()->json(['kode' => 'masuk', 'status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
    }

    try {
        // Logika ini menyimpan atau memperbarui data di tabel 'masuk'
        $masukEntry = Masuk::updateOrCreate(
            ['id_kendaraan' => $uid],
            ['waktu' => Carbon::now()]
        );
        
        // Tambahkan log ini
    // Log::info('MENCOBA MENGIRIM BROADCAST KE PUSHER...');
    
    // // broadcast(new RefreshParkingTable());

    // Log::info('BROADCAST BERHASIL DIKIRIM (TANPA ERROR).');

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


// Rute untuk MENCATAT KARTU KELUAR
Route::post('/kartu/keluar', function (Request $request) {
    $uid = $request->input('uid');

    if (empty($uid)) {
        Log::warning('Permintaan UID keluar kosong diterima.');
        return response()->json(['status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
    }

    try {
        // Mencari entri di tabel 'masuk' berdasarkan 'id_kendaraan'
        $masukEntry = Masuk::where('id_kendaraan', $uid)->first();

        if (!$masukEntry) {
            Log::warning('UID ' . $uid . ' tidak ditemukan di tabel MASUK saat mencoba KELUAR.');
            return response()->json(['status' => 'error', 'message' => 'Kendaraan ini tidak tercatat masuk'], 404);
        }

        $waktuMasuk = Carbon::parse($masukEntry->waktu);
        $waktuKeluar = Carbon::now();

        // $durasiMenit = abs($waktuKeluar->diffInMinutes($waktuMasuk));
        
        // $durasiJam = ceil($durasiMenit / 60);
        // if ($durasiJam == 0) $durasiJam = 1; // Minimal dihitung 1 jam
        // $tarif = $durasiJam * 2000;


        $durasiDetik = round(abs($waktuKeluar->diffInSeconds($waktuMasuk))); // <-- Tambahkan round()
        // Anda masih bisa menghitung durasiMenit dan durasiJam untuk tarif
        $durasiMenit = ceil($durasiDetik / 60); // Menit dibulatkan ke atas jika perlu
        $durasiJam = ceil($durasiMenit / 60); // Jam dibulatkan ke atas jika perlu
        if ($durasiJam == 0) $durasiJam = 1; // Minimal dihitung 1 jam
        $tarif = $durasiJam * 2000;


        // Catat ke 'detail_parkir'
        $detailParkir = DetailParkir::create([
            'id_kendaraan' => $uid,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => $waktuKeluar,
            'durasi' => $durasiDetik,
            'tarif' => $tarif,
        ]);

        // Hapus dari tabel 'masuk'
        $masukEntry->delete();
        Log::info('UID ' . $uid . ' berhasil dicatat KELUAR.');
        
        
        
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