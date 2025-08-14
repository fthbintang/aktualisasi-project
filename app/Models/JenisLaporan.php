<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisLaporan extends Model
{
    use HasFactory;

    protected $table = 'jenis_laporan';
    protected $guarded = ['id'];

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }
}