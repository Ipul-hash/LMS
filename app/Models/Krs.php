<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id', 'dosen_pa_id', 'periode_semester', 'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosenPa()
    {
        return $this->belongsTo(User::class, 'dosen_pa_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailKrs::class, 'krs_id');
    }
}