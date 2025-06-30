@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Daftar Pengguna</h1>

{{-- Tombol untuk Membuat User Baru (Hanya untuk Super Admin) --}}
@can('create-user')
<div class="mb-4">
    <a href="{{ route('users.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Buat User Baru
    </a>
</div>
@endcan

{{-- Notifikasi Sukses --}}
@if (session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Role</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                </th>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span
                        class="px-2 py-1 font-semibold leading-tight rounded-full {{ $user->role === 'super_admin' ? 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' : 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100' }}">
                        {{ Str::replace('_', ' ', Str::title($user->role)) }}
                    </span>
                </td>

                <td class="px-6 py-4">
                    {{-- Tombol Aksi (Edit/Hapus) - Hanya untuk Super Admin --}}
                    @can('create-user') {{-- Menggunakan gate 'create-user' --}}
                        <a href="{{ route('users.edit', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</a>
                        
                        {{-- Form untuk tombol Hapus --}}
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?');" class="inline-block">
                            @csrf
                            @method('DELETE') {{-- PENTING: Menggunakan @method('DELETE') --}}
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                        </form>
                    @else
                        - {{-- Tampilkan strip jika tidak ada izin --}}
                    @endcan
                </td>
            </tr>
            @empty
            <tr class="bg-white border-b dark:bg-gray-800">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Belum ada pengguna terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginasi --}}
<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection