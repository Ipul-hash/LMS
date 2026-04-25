<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    protected $fillable = ['tahun_akademik', 'semester', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFullLabelAttribute()
    {
        return "{$this->tahun_akademik} - {$this->semester}";
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'academic_period_id');
    }
}