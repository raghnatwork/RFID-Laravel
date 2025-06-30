{{-- Memberitahu Blade untuk menggunakan template dari layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') yang ada di template utama --}}
@section('title', 'Parkir Masuk')

{{-- Ini adalah konten yang akan dimasukkan ke dalam @yield('content') --}}
@section('content')
    <div style="text-align: center; margin-top: 50px; font-family: sans-serif;">
        <h1>My First Livewire Component</h1>
        {{-- Direktif @livewire akan merender komponen Livewire 'counter' --}}
        @livewire('counter')
    </div>
@endsection
