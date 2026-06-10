<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanSekolah extends Model
{
    protected $table = 'laporan_sekolah';

    protected $fillable = [
        'pengiriman_id',
        'porsi_diterima',
        'food_waste',
        'rating',
        'foto_makanan',
        'komentar',
    ];

    // ── Relationships ──

    public function pengiriman(): BelongsTo
    {
        return $this->belongsTo(Pengiriman::class);
    }

    // ── Helpers ──

    public function getWastePercentage(): float
    {
        $total = $this->porsi_diterima + $this->food_waste;
        if ($total === 0) return 0;

        return round(($this->food_waste / $total) * 100, 1);
    }
}
