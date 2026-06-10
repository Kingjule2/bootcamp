@if($showKirimModal)
    <x-components.shared.modal show="showKirimModal" title="🚚 Kirim Makanan" maxWidth="440px">
        <p style="font-size: 0.8125rem; color: var(--color-text-secondary); margin: 0 0 1.25rem;">
            Masukkan nama kurir yang akan mengantarkan makanan.
        </p>
        
        <x-components.shared.input 
            label="Nama Kurir" 
            name="namaKurir" 
            wire:model="namaKurir" 
            placeholder="Contoh: Andi Prasetyo" 
            autofocus 
        />

        <x-slot name="footer">
            <x-components.shared.button wire:click="cancelKirim" variant="secondary">Batal</x-components.shared.button>
            <x-components.shared.button wire:click="confirmKirim" variant="primary">
                🚚 Konfirmasi Kirim
            </x-components.shared.button>
        </x-slot>
    </x-components.shared.modal>
@endif
