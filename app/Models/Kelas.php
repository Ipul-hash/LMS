<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'matkul_id', 'dosen_id', 'nama_kelas', 'kapasitas', 'periode_semester'
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'kelas_id');
    }

    public function detailKrs()
    {
        return $this->hasMany(DetailKrs::class, 'kelas_id');
    }
}