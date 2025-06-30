<div>
    {{-- Setiap view Livewire harus dibungkus oleh satu elemen div utama. --}}
    {{-- Kode di dalam div ini akan otomatis di-update oleh Livewire. --}}

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
                    {{-- wire:key penting untuk membantu Livewire melacak setiap baris data secara efisien --}}
                    <tr wire:key="{{ $item->id_kendaraan }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{-- Nomor urut yang benar untuk paginasi --}}
                            {{ $loop->iteration + ($kendaraan->currentPage() - 1) * $kendaraan->perPage() }}
                        </th>
                        <td class="px-6 py-4">{{ $item->id_kendaraan }}</td>
                        <td class="px-6 py-4">
                            {{-- Karena 'waktu' sudah di-cast menjadi objek Carbon di Model, kita bisa langsung format --}}
                            {{ $item->waktu->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    {{-- Tampilan jika tidak ada data sama sekali --}}
                    <tr class="bg-white border-b dark:bg-gray-800">
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Belum ada kendaraan yang parkir.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link untuk navigasi halaman paginasi --}}
    <div class="mt-4">
        {{ $kendaraan->links() }}
    </div>
</div>
