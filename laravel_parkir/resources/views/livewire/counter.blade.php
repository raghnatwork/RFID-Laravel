<div>
    <h1>Livewire Counter</h1>
    <p>Current Count: {{ $count }}</p> {{-- Menampilkan nilai properti $count --}}

    {{-- `wire:click` akan memanggil metode PHP `increment()` di komponen --}}
    <button wire:click="increment">+</button>

    {{-- `wire:click` akan memanggil metode PHP `decrement()` di komponen --}}
    <button wire:click="decrement">-</button>
</div>