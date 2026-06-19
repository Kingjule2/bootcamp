<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_users';

    protected $fillable = [
        'username',
        'password',
        'role',
        'nama_entitas',
        'status_akun',
        'email',
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

    public function isKurir(): bool
    {
        return $this->role === 'kurir';
    }

    // ── Relationships ──

    public function sekolah(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Sekolah::class, 'id_users', 'id_users');
    }

    public function kurir(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kurir::class, 'id_users', 'id_users');
    }

    public function ahliGizi(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AhliGizi::class, 'id_users', 'id_users');
    }

    /** Menus submitted by this dapur */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'dapur_id', 'id_users');
    }

    /** Menus targeted at this sekolah */
    public function targetMenus(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Menu::class,
            Sekolah::class,
            'id_users',       // Foreign key on sekolah table
            'id_sekolah',     // Foreign key on menus table
            'id_users',       // Local key on users table
            'id_sekolah'      // Local key on sekolah table
        );
    }
}
