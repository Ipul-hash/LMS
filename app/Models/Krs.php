<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id',
        'academic_period_id', 
        'dosen_pa_id',       
        'status',
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(KrsItem::class, 'krs_id');
    }

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

    public function academicPeriod()
    {
        return $this->belongsTo(academicPeriod::class, 'academic_period_id');
    }
}