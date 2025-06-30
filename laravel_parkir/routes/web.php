<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Dasboard
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Model dan Controller Parkir
// use App\Models\Masuk;
// use App\Models\DetailParkir;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\DetailParkirController;

// Users
use App\Http\Controllers\UserController;

// Untuk timestamp
// use Illuminate\Support\Carbon;

Route::get('/test', function () {
    return view('test_parkir');
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/parkir', [MasukController::class, 'index'])->name('parkir.index');
    Route::get('/riwayat-parkir', [DetailParkirController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat-parkir/export-excel', [DetailParkirController::class, 'exportExcel'])->name('riwayat.export.excel');

   Route::middleware('can:access-admin-features')->group(function () {
        // Rute untuk MENAMPILKAN DAFTAR SEMUA USER
        // Ini adalah rute yang dicari dengan `route('users.index')`
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // Grup Rute untuk Membuat User (Hanya untuk Super Admin)
        // Gate 'create-user' harus didefinisikan di AuthServiceProvider
        // untuk hanya mengizinkan 'super_admin' mengakses ini.
        Route::middleware('can:create-user')->group(function () {
            // Rute untuk MENAMPILKAN FORM PEMBUATAN USER BARU
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            // Rute untuk MEMPROSES DATA FORM PEMBUATAN USER BARU
            Route::post('/users', [UserController::class, 'store'])->name('users.store');

             // --- TAMBAHKAN RUTE INI UNTUK EDIT DAN DELETE ---
            // Rute untuk menampilkan form edit user tertentu
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            // Rute untuk memproses update user tertentu (menggunakan PUT/PATCH)
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            // Rute untuk menghapus user tertentu (menggunakan DELETE)
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            });
    });
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// // Rute untuk menerima data kartu dari NodeMCU
// Route::post('/kartu/masuk', function (Request $request) {
//     $uid = $request->input('uid');

//     if (empty($uid)) {
//         Log::warning('Permintaan UID masuk kosong diterima.');
//         return response()->json(['status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
//     }

//     try {
//         // Logika ini menyimpan atau memperbarui data di tabel 'masuk'
//         $masukEntry = Masuk::updateOrCreate(
//             ['id_kendaraan' => $uid],
//             ['waktu' => Carbon::now()]
//         );
        
//         Log::info('UID ' . $uid . ' berhasil dicatat MASUK.');

//         return response()->json([
//             'status' => 'success',
//             'message' => 'UID diterima dan data waktu diperbarui/disimpan',
//             'data' => [
//                 'uid' => $masukEntry->id_kendaraan,
//                 'time' => $masukEntry->waktu->toDateTimeString(),
//                 'action' => $masukEntry->wasRecentlyCreated ? 'created' : "updated"
//             ]
//         ], 200);

//     } catch (\Exception $e) {
//         Log::error('Gagal memproses data masuk UID: ' . $uid . ' - ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan server'], 500);
//     }
// });


// Rute untuk MENCATAT KARTU KELUAR
// Route::post('/kartu/keluar', function (Request $request) {
//     $uid = $request->input('uid');

//     if (empty($uid)) {
//         Log::warning('Permintaan UID keluar kosong diterima.');
//         return response()->json(['status' => 'error', 'message' => 'UID tidak boleh kosong'], 400);
//     }

//     try {
//         // Mencari entri di tabel 'masuk' berdasarkan 'id_kendaraan'
//         $masukEntry = Masuk::where('id_kendaraan', $uid)->first();

//         if (!$masukEntry) {
//             Log::warning('UID ' . $uid . ' tidak ditemukan di tabel MASUK saat mencoba KELUAR.');
//             return response()->json(['status' => 'error', 'message' => 'Kendaraan ini tidak tercatat masuk'], 404);
//         }

//         $waktuMasuk = Carbon::parse($masukEntry->waktu);
//         $waktuKeluar = Carbon::now();

//         $durasiMenit = abs($waktuKeluar->diffInMinutes($waktuMasuk));
        
//         $durasiJam = ceil($durasiMenit / 60);
//         if ($durasiJam == 0) $durasiJam = 1; // Minimal dihitung 1 jam
//         $tarif = $durasiJam * 2000;

//         // Catat ke 'detail_parkir'
//         $detailParkir = DetailParkir::create([
//             'id_kendaraan' => $uid,
//             'waktu_masuk' => $waktuMasuk,
//             'waktu_keluar' => $waktuKeluar,
//             'durasi' => $durasiMenit,
//             'tarif' => $tarif,
//         ]);

//         // Hapus dari tabel 'masuk'
//         $masukEntry->delete();
//         Log::info('UID ' . $uid . ' berhasil dicatat KELUAR.');
        
//         return response()->json([
//             'status' => 'success',
//             'message' => 'Kendaraan berhasil keluar',
//             'data' => [
//                 'uid' => $uid,
//                 'waktu_masuk' => $waktuMasuk->toDateTimeString(),
//                 'waktu_keluar' => $waktuKeluar->toDateTimeString(),
//                 'durasi_menit' => $durasiMenit,
//                 'tarif' => $tarif
//             ]
//         ], 200);

//     } catch (\Exception $e) {
//         Log::error('Gagal memproses data KELUAR UID: ' . $uid . ' - ' . $e->getMessage());
//         return response()->json(['status' => 'error','message' => 'Terjadi kesalahan server saat proses keluar'], 500);
//     }
// });