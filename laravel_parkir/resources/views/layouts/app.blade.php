<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default')</title>

    @livewireStyles
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Memuat CSS dan JS Anda via Vite --}}
    @vite(['resources/css/app.css'])
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
</head>

<body class="bg-gray-50 dark:bg-gray-900"> {{-- Gunakan flex untuk layout sidebar --}}


    @include('layouts.sidebar')

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            @yield('content')


        </div>
    </div>


   
    @livewireScripts
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>