<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'nim_nip', 'name', 'email', 'password','is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kelasDiajar()
    {
        return $this->hasMany(Kelas::class, 'dosen_id');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');
    }

    public function krsBimbingan()
    {
        return $this->hasMany(Krs::class, 'dosen_pa_id');
    }
}