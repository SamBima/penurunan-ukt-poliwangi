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
        'email',
        'password',
        'role',
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
        ];
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function hasilValidasi()
    {
        return $this->hasMany(HasilValidasi::class);
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKeuangan()
    {
        return $this->role === 'keuangan';
    }

    public function isWadir()
    {
        return $this->role === 'wadir';
    }
}
