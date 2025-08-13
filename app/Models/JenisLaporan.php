<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisLaporan extends Model
{
    use HasFactory;

    protected $table = 'jenis_laporan';
    protected $guarded = ['id'];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }
}