<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AhliGizi extends Model
{
    protected $table = 'ahli_gizi';
    protected $primaryKey = 'id_ahli_gizi';

    protected $fillable = [
        'id_users',
        'no_str',
        'spesialisasi',
        'min_kalori',
        'max_kalori',
        'min_protein',
        'max_karbohidrat',
        'max_lemak',
        'status_menu',
        'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function menus(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menu::class, 'id_ahli_gizi', 'id_ahli_gizi');
    }
}
