@if($showUserModal)
    <x-components.shared.modal show="showUserModal" title="{{ $editingUserId ? '✏️ Edit Data User' : '➕ Tambah User Baru' }}" maxWidth="560px">
        <form wire:submit.prevent="saveUser">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label for="nama_entitas" class="form-label">Nama Lengkap / Instansi</label>
                    <input type="text" id="nama_entitas" wire:model="nama_entitas" class="form-input" placeholder="Contoh: SDN 02 Cinere">
                    @error('nama_entitas') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role / Peran</label>
                    <select id="role" wire:model.live="role" class="form-input" {{ $editingUserId ? 'disabled' : '' }}>
                        <option value="">-- Pilih Role --</option>
                        <option value="dapur">Dapur/Katering</option>
                        <option value="ahli_gizi">Ahli Gizi</option>
                        <option value="sekolah">Sekolah</option>
                        <option value="kurir">Kurir</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" wire:model="username" class="form-input" placeholder="sekolah_cinere">
                    @error('username') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" id="email" wire:model="email" class="form-input" placeholder="cinere@sch.id">
                    @error('email') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="password" class="form-label">Password {{ $editingUserId ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
                <input type="password" id="password" wire:model="password" class="form-input" placeholder="Minimal 6 karakter">
                @error('password') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
            </div>

            {{-- Conditional Fields for Sekolah --}}
            @if($role === 'sekolah')
                <div style="border-top: 1px solid var(--color-border); padding-top: 1rem; margin-top: 1rem;">
                    <h4 style="font-size: 0.8125rem; font-weight: 700; color: var(--color-primary-700); margin: 0 0 1rem;">🏫 Informasi Sekolah</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="NIS" class="form-label">Nomor Induk Sekolah (NIS)</label>
                            <input type="text" id="NIS" wire:model="NIS" class="form-input" placeholder="100023">
                            @error('NIS') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah_siswa" class="form-label">Jumlah Siswa</label>
                            <input type="number" id="jumlah_siswa" wire:model="jumlah_siswa" class="form-input" min="0">
                            @error('jumlah_siswa') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label for="no_telp" class="form-label">Nomor Telpon</label>
                        <input type="text" id="no_telp" wire:model="no_telp" class="form-input" placeholder="021-xxxxxx">
                        @error('no_telp') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            {{-- Conditional Fields for Kurir --}}
            @if($role === 'kurir')
                <div style="border-top: 1px solid var(--color-border); padding-top: 1rem; margin-top: 1rem;">
                    <h4 style="font-size: 0.8125rem; font-weight: 700; color: var(--color-primary-700); margin: 0 0 1rem;">🚚 Informasi Kurir</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="plat_nomor" class="form-label">Plat Nomor Kendaraan</label>
                            <input type="text" id="plat_nomor" wire:model="plat_nomor" class="form-input" placeholder="B 1234 ABC">
                            @error('plat_nomor') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                            <select id="jenis_kendaraan" wire:model="jenis_kendaraan" class="form-input">
                                <option value="Motor">Motor</option>
                                <option value="Mobil Box">Mobil Box</option>
                                <option value="Cukup">Mobil Pribadi / Mini Van</option>
                            </select>
                            @error('jenis_kendaraan') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label for="no_telp" class="form-label">Nomor Telpon Aktif (WhatsApp)</label>
                        <input type="text" id="no_telp" wire:model="no_telp" class="form-input" placeholder="08xxxxxxxxxx">
                        @error('no_telp') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            {{-- Conditional Fields for Ahli Gizi --}}
            @if($role === 'ahli_gizi')
                <div style="border-top: 1px solid var(--color-border); padding-top: 1rem; margin-top: 1rem;">
                    <h4 style="font-size: 0.8125rem; font-weight: 700; color: var(--color-primary-700); margin: 0 0 1rem;">🩺 Informasi Ahli Gizi</h4>
                    <div class="form-group">
                        <label for="no_str" class="form-label">Nomor STR (Surat Tanda Registrasi)</label>
                        <input type="text" id="no_str" wire:model="no_str" class="form-input" placeholder="STR-xxxxxxxx-xxxx">
                        @error('no_str') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label for="spesialisasi" class="form-label">Spesialisasi / Deskripsi Dinas</label>
                        <input type="text" id="spesialisasi" wire:model="spesialisasi" class="form-input" placeholder="Contoh: Ahli Gizi Balita & Anak Sekolah">
                        @error('spesialisasi') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <x-slot name="footer">
                <x-components.shared.button wire:click="closeUserModal" variant="secondary">Batal</x-components.shared.button>
                <x-components.shared.button type="submit" variant="primary">
                    💾 Simpan Data
                </x-components.shared.button>
            </x-slot>
        </form>
    </x-components.shared.modal>
@endif
