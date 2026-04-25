<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KrsItem extends Model
{
    protected $table = 'krs_items';

    protected $fillable = [
        'krs_id',
        'kelas_id',
        'sks_point'
    ];

    public function krs(): BelongsTo
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    public function kelas(): BelongsTo
    {
       return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}