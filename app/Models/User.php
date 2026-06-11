<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telepon',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    // ✅ Owner, Admin, Staff Gudang bisa akses panel
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['owner', 'admin', 'staff_gudang']);
    }

    // Helper role checks
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isStaffGudang(): bool
    {
        return $this->role === 'staff_gudang';
    }
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProdukReview::class);
    }
    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class);
    }
    public function stokKeluar()
    {
        return $this->hasMany(StokKeluar::class);
    }

    public function getNamaAttribute()
    {
        return $this->name;
    }
}