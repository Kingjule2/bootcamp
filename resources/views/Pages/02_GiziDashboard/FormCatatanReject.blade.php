@if($showRejectInput)
    <div style="animation: slideIn 0.3s ease;">
        <x-components.shared.input 
            label="⚠️ Catatan Penolakan (Wajib)" 
            name="catatan_gizi" 
            type="textarea" 
            wire:model="catatan_gizi" 
            rows="3" 
            placeholder="Contoh: Sayuran kurang bervariasi, ganti dengan sayur yang tinggi serat..." 
            style="border-color: #fecaca; resize: vertical;" 
            autofocus 
        />
    </div>
@endif
