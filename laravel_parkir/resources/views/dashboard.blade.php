@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Jumlah Kendaraan Dalam 7 Hari Terakhir</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- KOTAK UNTUK LINE CHART --}}
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <canvas id="lineChart"></canvas>
        </div>

        {{-- KOTAK UNTUK BAR CHART --}}
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
           
            <canvas id="barChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mengambil data yang sudah di-passing dari controller
    const lineChartData = {!! json_encode($lineChartData) !!};
    const barChartData = {!! json_encode($barChartData) !!};

    // --- LOGIKA UNTUK LINE CHART ---
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: lineChartData.labels,
            datasets: [{
                label: 'Kendaraan',
                data: lineChartData.data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Hanya tampilkan angka bulat di sumbu Y
                    }
                }
            }
        }
    });

    // --- LOGIKA UNTUK BAR CHART ---
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: barChartData.labels,
            datasets: [{
                label: 'Kendaraan',
                data: barChartData.data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush