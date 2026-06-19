<div class="card">
    <div class="card-header">
        <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">Input Menu Harian</h3>
    </div>
    <div class="card-body">
        @if(session('menu-success'))
            <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.75rem 1rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 0.8125rem; color: #065f46;">{{ session('menu-success') }}</span>
            </div>
        @endif

        <form wire:submit="submit">
            <x-components.shared.input 
                label="Rincian Menu Makanan" 
                name="nama_menu" 
                type="textarea" 
                wire:model="nama_menu" 
                placeholder="Contoh: Nasi Putih, Ayam Goreng Lengkuas, Tumis Buncis, Buah Jeruk" 
                rows="3" 
                style="resize: vertical;" 
            />

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <x-components.shared.input 
                    label="Est. Kalori (kkal)" 
                    name="kalori" 
                    type="number" 
                    wire:model="kalori" 
                    placeholder="650" 
                    min="400" 
                    max="1500" 
                />
                <x-components.shared.input 
                    label="Protein (gram)" 
                    name="protein" 
                    type="number" 
                    wire:model="protein" 
                    placeholder="25" 
                    min="10" 
                    max="100" 
                />
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <x-components.shared.input 
                    label="Jumlah Porsi" 
                    name="porsi_rencana" 
                    type="number" 
                    wire:model="porsi_rencana" 
                    placeholder="500" 
                    min="1" 
                    max="5000" 
                />
                <div class="form-group">
                    <label for="id_sekolah" class="form-label">Sekolah Tujuan</label>
                    <select wire:model="id_sekolah" id="id_sekolah" class="form-input">
                        <option value="">— Pilih Sekolah —</option>
                        @foreach($sekolahList as $sekolah)
                            <option value="{{ $sekolah->id_sekolah }}">{{ $sekolah->user->nama_entitas ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('id_sekolah') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <x-components.shared.button type="submit" variant="primary" size="lg" style="width: 100%; margin-top: 0.5rem;">
                Ajukan Menu untuk Verifikasi
            </x-components.shared.button>
        </form>
    </div>
</div>
