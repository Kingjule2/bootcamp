<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $fillable = [
        'dapur_id',
        'target_sekolah_id',
        'nama_menu',
        'kalori',
        'protein',
        'porsi_rencana',
        'status',
        'catatan_gizi',
    ];

    // ── Relationships ──

    public function dapur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dapur_id');
    }

    public function targetSekolah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_sekolah_id');
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class);
    }

    // ── Status Helpers ──

    public function isPending(): bool
    {
        return $this->status === 'Pending Verification';
    }

    public function isApproved(): bool
    {
        return $this->status === 'Ready to Cook';
    }

    public function isRejected(): bool
    {
        return $this->status === 'Rejected';
    }
}
