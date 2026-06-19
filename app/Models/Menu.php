<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $primaryKey = 'id_menus';

    protected $fillable = [
        'dapur_id',
        'id_sekolah',
        'nama_menu',
        'kalori',
        'protein',
        'porsi_rencana',
        'status',
        'catatan_gizi',
        'karbohidrat',
        'lemak',
        'id_ahli_gizi',
    ];

    // ── Relationships ──

    public function dapur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dapur_id', 'id_users');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function targetSekolah()
    {
        return $this->hasOneThrough(
            User::class,
            Sekolah::class,
            'id_sekolah',     // Foreign key on sekolah table
            'id_users',       // Foreign key on users table
            'id_sekolah',     // Local key on menus table
            'id_users'        // Local key on sekolah table
        );
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class, 'id_menus', 'id_menus');
    }

    public function ahliGizi(): BelongsTo
    {
        return $this->belongsTo(AhliGizi::class, 'id_ahli_gizi', 'id_ahli_gizi');
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
