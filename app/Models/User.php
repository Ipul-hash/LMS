<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nim_nip', 'name', 'email', 'password', 'peran'
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