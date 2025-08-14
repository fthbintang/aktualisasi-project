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

    public function jenis_laporan()
    {
        return $this->belongsTo(JenisLaporan::class);
    }

    public function upload_laporan()
    {
        return $this->hasMany(UploadLaporan::class);
    }
}