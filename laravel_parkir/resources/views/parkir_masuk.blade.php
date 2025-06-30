{{-- Memberitahu Blade untuk menggunakan template dari layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') yang ada di template utama --}}
@section('title', 'Parkir Masuk')

{{-- Ini adalah konten yang akan dimasukkan ke dalam @yield('content') --}}
@section('content')

<h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Parkir</h1>

{{-- Form Search --}}
<div class="mb-4 p-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
    <form action="{{ route('parkir.index') }}" method="GET" class="flex items-center relative">
        <label for="default-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" id="default-search" name="search"
                   value="{{ $search ?? '' }}" {{-- Menjaga nilai search input setelah reload --}}
                   class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="Cari ID Kendaraan..." required />
            <button type="submit"
                    class="text-white mt-5 absolute end-2.5 bottom-1.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Search
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

            </tr>
        </thead>
        <tbody>
            @forelse ($kendaraan as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{-- Nomor urut sesuai halaman paginasi --}}
                    {{ $loop->iteration + ($kendaraan->currentPage() - 1) * $kendaraan->perPage() }}
                </th>
                <td class="px-6 py-4">{{ $item->id_kendaraan }}</td>
                <td class="px-6 py-4">{{ $item->waktu ->format('d M Y, H:i')}}</td>
            </tr>
            @empty
            <tr class="bg-white border-b dark:bg-gray-800">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Belum ada parkir masuk.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Ini untuk menampilkan link ke halaman selanjutnya (1, 2, 3, ...) --}}
<div class="mt-4">
    {{ $kendaraan->links() }}
</div>



@endsection