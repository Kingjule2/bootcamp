<div>
    {{-- Flash Message --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Manajemen Pengiriman</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            @forelse($pengirimans as $p)
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.35rem;" class="truncate-2">
                                {{ $p->menu->nama_menu }}
                            </div>
                            <div style="font-size: 0.8125rem; color: var(--color-text-muted); display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                <span>Sekolah: {{ $p->menu->targetSekolah->nama_entitas }}</span>
                                <span>Porsi: {{ $p->menu->porsi_rencana }} porsi</span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                            @if($p->status_logistik === 'Sedang Dimasak')
                                <button wire:click="kirimMakanan({{ $p->id_pengiriman }})" class="btn" style="background: var(--color-primary-600); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-weight: 600; cursor: pointer;">
                                    🚚 Kirim Makanan
                                </button>
                            @else
                                <span class="badge badge-{{ $p->status_logistik === 'Diterima' ? 'received' : 'transit' }}">
                                    {{ $p->status_logistik }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($p->dispatched_at)
                        <div style="margin-top: 0.75rem; font-size: 0.8125rem; color: var(--color-text-muted);">
                            🚚 Kurir: <strong>{{ $p->kurir?->user?->nama_entitas ?? '-' }}</strong> &middot; Berangkat: {{ $p->dispatched_at->format('H:i') }} WIB
                            @if($p->received_at)
                                &middot; Diterima: {{ $p->received_at->format('H:i') }} WIB
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                    <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Belum ada antrean pengiriman.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Konfirmasi Kirim --}}
    @if($showKirimModal)
    <div style="position: fixed; inset: 0; z-index: 100; display: flex; align-items: center; justify-content: center;">
        <!-- Backdrop -->
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px);" wire:click="cancelKirim"></div>
        
        <!-- Modal Content -->
        <div style="position: relative; background: white; width: 100%; max-width: 24rem; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); overflow: hidden; animation: slideUp 0.3s ease-out;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--color-border);">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: var(--color-text-primary);">Dispatch Pengiriman</h3>
            </div>
            
            <div style="padding: 1.5rem;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 500; font-size: 0.875rem; color: var(--color-text-primary); display: block; margin-bottom: 0.375rem;">Pilih Kurir Bertugas</label>
                    <select class="form-control" wire:model="selectedKurirId" style="width: 100%; border-radius: 0.5rem; border: 1px solid var(--color-border); padding: 0.625rem 0.875rem; font-size: 0.875rem; background: var(--color-background-primary); color: var(--color-text-primary);" autofocus>
                        <option value="">-- Pilih Kurir --</option>
                        @foreach($kurirs as $kurir)
                            <option value="{{ $kurir->id_kurir }}">{{ $kurir->user->nama_entitas }} ({{ $kurir->plat_nomor }})</option>
                        @endforeach
                    </select>
                    @error('selectedKurirId') <span style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>
                <div style="font-size: 0.8125rem; color: var(--color-text-muted); margin-top: 1rem; background: #f8fafc; padding: 0.75rem; border-radius: 0.5rem;">
                    💡 Pilih kurir bertugas agar data pengiriman dapat terverifikasi secara akurat.
                </div>
            </div>
            
            <div style="padding: 1rem 1.5rem; background: #f8fafc; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button wire:click="cancelKirim" class="btn" style="background: white; border: 1px solid var(--color-border); color: var(--color-text-primary); padding: 0.5rem 1rem;">Batal</button>
                <button wire:click="confirmKirim" class="btn" style="background: var(--color-primary-600); border: none; color: white; padding: 0.5rem 1rem;">Kirim Sekarang</button>
            </div>
        </div>
    </div>
    @endif
</div>
