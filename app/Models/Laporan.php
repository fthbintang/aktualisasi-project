<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $guarded = ['id'];

    public function jenis_laporan(): HasMany
    {
        return $this->hasMany(JenisLaporan::class);
    }

    public function upload_laporan(): BelongsTo
    {
        return $this->belongsTo(UploadLaporan::class);
    }
}