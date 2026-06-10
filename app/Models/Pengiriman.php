<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'menu_id',
        'nama_kurir',
        'status_logistik',
        'dispatched_at',
        'received_at',
        'is_synced',
        'device_info',
    ];

    protected function casts(): array
    {
        return [
            'dispatched_at' => 'datetime',
            'received_at' => 'datetime',
            'is_synced' => 'boolean',
        ];
    }

    // ── Relationships ──

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function laporanSekolah(): HasOne
    {
        return $this->hasOne(LaporanSekolah::class);
    }

    // ── Status Helpers ──

    public function isOverdue(): bool
    {
        if ($this->status_logistik !== 'Dalam Perjalanan' || !$this->dispatched_at) {
            return false;
        }

        return $this->dispatched_at->diffInMinutes(now()) > 120;
    }

    public function isWarning(): bool
    {
        if ($this->status_logistik !== 'Dalam Perjalanan' || !$this->dispatched_at) {
            return false;
        }

        $minutes = $this->dispatched_at->diffInMinutes(now());
        return $minutes > 60 && $minutes <= 120;
    }

    public function getDeliveryDurationMinutes(): ?int
    {
        if (!$this->dispatched_at) {
            return null;
        }

        $end = $this->received_at ?? now();
        return (int) $this->dispatched_at->diffInMinutes($end);
    }
}
