import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],

    // server: {
    //     host: '0.0.0.0', // Vite mendengarkan di semua IP
    //     port: 5173,     // Pastikan port Vite ini (default)
    //     strictPort: true, // Pastikan port ini digunakan
    //     hmr: {
    //         host: '192.168.1.106', // <-- GANTI DENGAN IP ANDA
    //         clientPort: 5173, // Pastikan ini juga sesuai dengan port Vite
    //     },
    //     // --- INI BAGIAN PENTING UNTUK CORS SECARA EKSPLISIT ---
    //     headers: {
    //         // Mengizinkan semua origin untuk tujuan pengembangan.
    //         // Di produksi, ini harus diganti dengan domain spesifik Anda.
    //         'Access-Control-Allow-Origin': '*',
    //         'Access-Control-Allow-Methods': 'GET,HEAD,PUT,PATCH,POST,DELETE,OPTIONS',
    //         'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With, Accept',
    //     },
    // }
});
