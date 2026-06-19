@if($showKirimModal)
    <x-components.shared.modal show="showKirimModal" title="Kirim Makanan" maxWidth="440px">
        <p style="font-size: 0.8125rem; color: var(--color-text-secondary); margin: 0 0 1.25rem;">
            Pilih kurir yang akan mengantarkan makanan ke sekolah tujuan.
        </p>
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label for="selectedKurirId" class="form-label" style="font-weight: 500; font-size: 0.875rem; color: var(--color-text-primary); display: block; margin-bottom: 0.375rem;">Pilih Kurir</label>
            <select 
                id="selectedKurirId" 
                name="selectedKurirId" 
                wire:model="selectedKurirId" 
                class="form-input"
                style="width: 100%; border-radius: 0.5rem; border: 1px solid var(--color-border); padding: 0.625rem 0.875rem; font-size: 0.875rem; background: var(--color-background-primary); color: var(--color-text-primary);"
                autofocus
            >
                <option value="">-- Pilih Kurir --</option>
                @foreach($kurirs as $kurir)
                    <option value="{{ $kurir->id_kurir }}">{{ $kurir->user->nama_entitas }} ({{ $kurir->plat_nomor }})</option>
                @endforeach
            </select>
            @error('selectedKurirId')
                <div class="form-error" style="color: var(--color-danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <x-slot name="footer">
            <x-components.shared.button wire:click="cancelKirim" variant="secondary">Batal</x-components.shared.button>
            <x-components.shared.button wire:click="confirmKirim" variant="primary">
                Konfirmasi Kirim
            </x-components.shared.button>
        </x-slot>
    </x-components.shared.modal>
@endif
