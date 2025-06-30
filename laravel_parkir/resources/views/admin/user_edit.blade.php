@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Edit Pengguna: {{ $user->name }}</h1>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6 bg-white dark:bg-gray-800">

    {{-- Notifikasi Sukses/Error --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tampilkan Error Validasi --}}
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit User --}}
    {{-- Action mengarah ke route 'users.update' dengan ID user --}}
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- PENTING: Menggunakan @method('PUT') untuk mengirim permintaan PUT --}}

        {{-- Input Nama --}}
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
            <input type="text" id="name" name="name"
                value="{{ old('name', $user->name) }}" {{-- old() untuk error validasi, $user->name untuk nilai awal --}}
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nama Lengkap" required>
        </div>

        {{-- Input Email --}}
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email', $user->email) }}" {{-- old() untuk error validasi, $user->email untuk nilai awal --}}
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="nama@contoh.com" required>
        </div>

        {{-- Input Password (Opsional saat Edit) --}}
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="••••••••"> {{-- Tidak ada value old() di sini untuk alasan keamanan --}}
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah password.</p>
        </div>

        {{-- Konfirmasi Password (Opsional saat Edit) --}}
        <div class="mb-5">
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="••••••••"> {{-- Tidak ada value old() di sini untuk alasan keamanan --}}
        </div>

        {{-- Input Role --}}
        <div class="mb-5">
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
            <select id="role" name="role"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
                {{-- old('role', $user->role) akan mempertahankan pilihan sebelumnya jika ada error validasi, atau mengambil dari $user --}}
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>

        {{-- Tombol Submit --}}
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Perbarui User
        </button>
        
        <a href="{{ route('users.index') }}" class="inline-block text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800 ml-2">
            Batal
        </a>
    </form>
</div>
@endsection