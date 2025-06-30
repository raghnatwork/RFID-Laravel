@extends('layouts.app')

@section('title', 'Riwayat Parkir')

@section('content')

<h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Riwayat Parkir</h1>

<div class="bg-white  dark:bg-gray-800 shadow-md sm:rounded-lg p-6 mb-6 ">
    <form action="{{ route('riwayat.export.excel') }}" method="GET"
        class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="w-full sm:w-auto">
            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari
                Tanggal:</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="w-full sm:w-auto">
            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai
                Tanggal:</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="w-full sm:w-auto">
            <button type="submit"
                class="mt-[20%] w-full sm:w-auto inline-flex items-center px-4 py-2  bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Excel
            </button>
        </div>
    </form>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Plat Nomor</th>
                <th scope="col" class="px-6 py-3">Waktu Masuk</th>
                <th scope="col" class="px-6 py-3">Waktu Keluar</th>
                <th scope="col" class="px-6 py-3">Durasi</th>
                <th scope="col" class="px-6 py-3">Tarif (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{-- Nomor urut sesuai halaman paginasi --}}
                    {{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}
                </th>
                <td class="px-6 py-4">{{ $item->id_kendaraan }}</td>
                <td class="px-6 py-4">{{ $item->waktu_masuk ? $item->waktu_masuk->format('d M Y, H:i') : '-' }}</td>
                <td class="px-6 py-4">{{ $item->waktu_keluar ? $item->waktu_keluar->format('d M Y, H:i') : '-' }}</td>
                <td class="px-6 py-4">{{ $item->formatted_duration }}</td>
                <td class="px-6 py-4">{{ number_format($item->tarif, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr class="bg-white border-b dark:bg-gray-800">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Belum ada riwayat parkir.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Ini untuk menampilkan link ke halaman selanjutnya (1, 2, 3, ...) --}}

</div>

<div class="mt-4">
    {{ $riwayat->links() }}
</div>

@endsection