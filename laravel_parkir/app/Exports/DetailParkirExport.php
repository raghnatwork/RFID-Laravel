<?php

namespace App\Exports;

use App\Models\DetailParkir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Untuk menambahkan header kolom
use Maatwebsite\Excel\Concerns\WithMapping; // Untuk memformat data baris
use PhpOffice\PhpSpreadsheet\Shared\Date; // Untuk format tanggal Excel
use Carbon\Carbon; // Untuk bekerja dengan tanggal

class DetailParkirExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate = null, string $endDate = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = DetailParkir::query();

        if ($this->startDate) {
            $query->where('waktu_masuk', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('waktu_keluar', '<=', $this->endDate); // Atau 'waktu_masuk' <= $this->endDate jika ingin berdasarkan masuk
        }

        return $query->orderBy('waktu_masuk', 'asc')->get();
    }

    /**
     * Definisi header kolom untuk Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Kendaraan',
            'Waktu Masuk',
            'Waktu Keluar',
            'Durasi (Detik)', // Sesuaikan jika Anda menampilkan HH:MM:SS di kolom ini
            'Tarif (Rp)',
        ];
    }

    /**
     * Memformat setiap baris data.
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id_kendaraan,
            $row->waktu_masuk ? $row->waktu_masuk->format('d/m/Y H:i:s') : '-', // Format tanggal
            $row->waktu_keluar ? $row->waktu_keluar->format('d/m/Y H:i:s') : '-', // Format tanggal
            $row->durasi, // Ini akan menggunakan nilai detik dari DB
            $row->tarif,
        ];
    }

    // Opsional: Jika ingin durasi dalam format HH:MM:SS di Excel
    // Anda bisa tambahkan ini jika Anda mau kolom durasi di Excel seperti itu
    // public function map($row): array
    // {
    //     return [
    //         $row->id_kendaraan,
    //         $row->waktu_masuk ? Date::dateTimeToExcel($row->waktu_masuk) : '', // Untuk format tanggal Excel
    //         $row->waktu_keluar ? Date::dateTimeToExcel($row->waktu_keluar) : '', // Untuk format tanggal Excel
    //         $row->formatted_duration, // Menggunakan accessor dari model DetailParkir
    //         $row->tarif,
    //     ];
    // }
}