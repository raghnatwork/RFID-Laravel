<?php

namespace App\Http\Controllers;

use App\Models\DetailParkir; // <-- 1. Import model DetailParkir
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // <-- Import Facade Excel
use App\Exports\DetailParkirExport;   // <-- Import Export Class Anda
class DetailParkirController extends Controller
{
    /**
     * Menampilkan halaman riwayat parkir.
     * Method ini akan kita panggil dari Rute.
     */
    public function index()
    {
        // 2. Ambil data dari database menggunakan model.
        // Kita urutkan berdasarkan waktu keluar yang paling baru.
        // Kita juga menggunakan paginate() agar data tidak dimuat semua sekaligus jika sudah sangat banyak.
        // Angka 15 berarti 15 data per halaman.
        $riwayat = DetailParkir::orderBy('waktu_keluar', 'desc')->paginate(10);

        // 3. Kirim data yang sudah diambil ke view 'riwayat_parkir'.
        // View akan menerima variabel bernama $riwayat.
        return view('riwayat_parkir', ['riwayat' => $riwayat]);
    }

    public function exportExcel(Request $request)
    {
        

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'riwayat_parkir';
        if ($startDate && $endDate) {
            $fileName .= '_dari_' . $startDate . '_sampai_' . $endDate;
        } elseif ($startDate) {
            $fileName .= '_dari_' . $startDate;
        } elseif ($endDate) {
            $fileName .= '_sampai_' . $endDate;
        }
        $fileName .= '.xlsx';

        // Memicu proses ekspor dengan rentang tanggal
        return Excel::download(new DetailParkirExport($startDate, $endDate), $fileName);
    }
}