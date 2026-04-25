<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'matkul_id', 
        'dosen_id', 
        'nama_kelas', 
        'kapasitas', 
        'periode_semester',
        'ruangan_id',
        'hari',       
        'jam_mulai',  
        'jam_selesai' 
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
        return $this->belongsTo(Materi::class, 'matkul_id');
    }

    public function detailKrs()
    {
        return $this->hasMany(DetailKrs::class, 'kelas_id');
    }
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function items()
    {
        return $this->hasMany(KrsItem::class, 'kelas_id');
    }
}