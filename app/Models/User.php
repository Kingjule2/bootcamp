<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
        'nama_entitas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ── Role Helpers ──

    public function isDapur(): bool
    {
        return $this->role === 'dapur';
    }

    public function isAhliGizi(): bool
    {
        return $this->role === 'ahli_gizi';
    }

    public function isSekolah(): bool
    {
        return $this->role === 'sekolah';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ── Relationships ──

    /** Menus submitted by this dapur */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'dapur_id');
    }

    /** Menus targeted at this sekolah */
    public function targetMenus(): HasMany
    {
        return $this->hasMany(Menu::class, 'target_sekolah_id');
    }
}
