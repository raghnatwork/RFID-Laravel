<?php

namespace App\Http\Controllers;

use App\Models\Masuk; // Jangan lupa import
use Illuminate\Http\Request;

class MasukController extends Controller
{
    /**
     * Method ini yang akan dipanggil oleh Rute di atas.
     */
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        // Ambil keyword pencarian dari URL (misal: /parkir?search=UID123)
        $search = $request->input('search'); // <-- Ambil input search

        // Mulai query dari model Masuk
        $query = Masuk::latest('waktu');

        // Jika ada keyword pencarian, tambahkan kondisi WHERE
        if (!empty($search)) {
            $query->where('id_kendaraan', 'like', '%' . $search . '%');
        }

        // Ambil data dengan pagination
        $kendaraan = $query->paginate(10);

        // Kirim data yang sudah diambil ke view, dan juga search keyword-nya
        return view('parkir_masuk', [
            'kendaraan' => $kendaraan,
            'search' => $search // <-- Kirim search keyword ke view
        ]);
    }


    
}