<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isPengawas(): bool
    {
        return $this->role === 'pengawas';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    public function diagnosas()
    {
        return $this->hasMany(Diagnosa::class, 'user_id');
    }

    public function tindakansSebagaiKaryawan()
    {
        return $this->hasMany(Tindakan::class, 'karyawan_id');
    }

    public function tindakansSebagaiPengawas()
    {
        return $this->hasMany(Tindakan::class, 'pengawas_id');
    }
}
