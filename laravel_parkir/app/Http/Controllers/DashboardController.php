<?php

namespace App\Http\Controllers;

use App\Models\Masuk;
use App\Models\DetailParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- DATA UNTUK LINE CHART (Data Masuk 7 Hari Terakhir) ---
        $chartLine = DetailParkir::select(
            DB::raw("DATE(waktu_keluar) as tanggal"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->where('waktu_keluar', '>=', now()->subDays(7)) // Ambil data 7 hari terakhir
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

        // dd($chartLine);

        // Olah data agar siap dipakai Chart.js
        $labelsLine = [];
        $dataLine = [];
        $tanggalSekarang = Carbon::now();
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = $tanggalSekarang->copy()->subDays($i);
            $labelsLine[] = $tanggal->format('d M'); // Format tanggal (e.g., 09 Jun)
            
            $jumlahPadaTanggal = $chartLine->firstWhere('tanggal', $tanggal->format('Y-m-d'));
            $dataLine[] = $jumlahPadaTanggal ? $jumlahPadaTanggal->jumlah : 0;
        }

        $lineChartData = [
            'labels' => $labelsLine,
            'data' => $dataLine,
        ];


        // --- DATA UNTUK BAR CHART (Riwayat Parkir 7 Hari Terakhir) ---
        $riwayatData = DetailParkir::select(
            DB::raw("DATE(waktu_keluar) as tanggal"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->whereNotNull('waktu_keluar')
        ->where('waktu_keluar', '>=', now()->subDays(7))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

        // Olah data (kita bisa gunakan labels yang sama dari line chart)
        $dataBar = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = $tanggalSekarang->copy()->subDays($i);
            $jumlahPadaTanggal = $riwayatData->firstWhere('tanggal', $tanggal->format('Y-m-d'));
            $dataBar[] = $jumlahPadaTanggal ? $jumlahPadaTanggal->jumlah : 0;
        }
        
        $barChartData = [
            'labels' => $labelsLine, // Pakai labels yang sama
            'data' => $dataBar,
        ];


        // Kirim semua data chart ke view
        return view('dashboard', compact('lineChartData', 'barChartData'));
    }
}