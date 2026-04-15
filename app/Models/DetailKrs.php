<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKrs extends Model
{
    protected $table = 'detail_krs';

    protected $fillable = ['krs_id', 'kelas_id'];

    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'detail_krs_id');
    }
}