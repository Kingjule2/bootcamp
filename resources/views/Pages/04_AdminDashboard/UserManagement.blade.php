<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">👥 Daftar Akun & Mitra Kerja MBG</h3>
        <x-components.shared.button wire:click="openAddUser" variant="primary" style="font-size: 0.8125rem; padding: 0.5rem 1rem;">
            ➕ Tambah User Baru
        </x-components.shared.button>
    </div>
    <div class="card-body" style="padding: 0; overflow-x: auto;">
        @if($users->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Entitas</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role / Peran</th>
                        <th>Detail Profile</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td style="font-weight: 600;">{{ $u->nama_entitas }}</td>
                            <td><code>{{ $u->username }}</code></td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role === 'admin')
                                    <span class="badge" style="background: #f3e8ff; color: #7e22ce;">Admin</span>
                                @elseif($u->role === 'dapur')
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1;">Dapur/Katering</span>
                                @elseif($u->role === 'ahli_gizi')
                                    <span class="badge" style="background: #ecfdf5; color: #047857;">Ahli Gizi</span>
                                @elseif($u->role === 'sekolah')
                                    <span class="badge" style="background: #fff7ed; color: #c2410c;">Sekolah</span>
                                @elseif($u->role === 'kurir')
                                    <span class="badge" style="background: #f1f5f9; color: #475569;">Kurir Logistik</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8125rem;">
                                @if($u->role === 'sekolah' && $u->sekolah)
                                    <span>NIS: {{ $u->sekolah->NIS }} · {{ $u->sekolah->jumlah_siswa }} siswa</span>
                                @elseif($u->role === 'kurir' && $u->kurir)
                                    <span>No. Plat: {{ $u->kurir->plat_nomor }} ({{ $u->kurir->jenis_kendaraan }})</span>
                                @elseif($u->role === 'ahli_gizi' && $u->ahliGizi)
                                    <span>STR: {{ $u->ahliGizi->no_str ?? '-' }}</span>
                                @else
                                    <span style="color: var(--color-text-muted); font-style: italic;">Tidak ada detail tambahan</span>
                                @endif
                            </td>
                            <td style="text-align: center; display: flex; justify-content: center; gap: 0.5rem;">
                                <x-components.shared.button wire:click="editUser({{ $u->id_users }})" variant="secondary" style="font-size: 0.75rem; padding: 0.375rem 0.75rem;">
                                    ✏️ Edit
                                </x-components.shared.button>
                                @if($u->id_users !== auth()->id())
                                    <x-components.shared.button 
                                        wire:click="deleteUser({{ $u->id_users }})" 
                                        variant="danger" 
                                        style="font-size: 0.75rem; padding: 0.375rem 0.75rem;"
                                        onclick="confirm('Apakah Anda yakin ingin menghapus user ini?') || event.stopImmediatePropagation()"
                                    >
                                        🗑️ Hapus
                                    </x-components.shared.button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👥</div>
                <p style="margin: 0;">Belum ada data user terdaftar.</p>
            </div>
        @endif
    </div>
</div>
