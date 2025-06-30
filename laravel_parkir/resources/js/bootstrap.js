import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// // test
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// console.log('--- Inisialisasi Laravel Echo ---');
// const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
// const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER;

// console.log('Mencoba menginisialisasi Echo dengan Key:', pusherKey, 'dan Cluster:', pusherCluster);

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: pusherKey,
//     cluster: pusherCluster,
//     forceTLS: true
// });

// if (window.Echo) {
//     console.log('✅ Laravel Echo berhasil diinisialisasi secara global.');

//     // --- PENTING: Tambahkan ini untuk debug ---
//     // Pastikan listener terdaftar setelah koneksi terhubung
//     window.Echo.connector.pusher.connection.bind('connected', () => {
//         console.log('%c 🌐 Pusher Connected! Registering Listener Now... ', 'background: #007bff; color: #ffffff; font-weight: bold; padding: 4px;');

//         window.Echo.channel('parking-updates')
//             .listen('table.refreshed', (e) => {
//                 console.log('%c 🎉 Event table.refreshed DITERIMA OLEH LISTENER JAVASCRIPT LANGSUNG! ', 'background: #22c55e; color: #ffffff; font-weight: bold; padding: 4px;', e);
//                 alert('Event Diterima!'); // Biarkan ini aktif untuk sementara
//             });

//         console.log("👂 Berhasil mendaftarkan listener langsung untuk channel 'parking-updates' dan event 'table.refreshed'.");
//     });


// } else {
//     console.error('❌ Inisialisasi Laravel Echo GAGAL.');
// }