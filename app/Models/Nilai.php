<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'detail_krs_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'huruf_mutu'
    ];

    public function detailKrs()
    {
        return $this->belongsTo(DetailKrs::class, 'detail_krs_id');
    }
}