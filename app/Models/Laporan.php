<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $guarded = ['id'];

    // Relasi: Laporan milik Jenis Laporan
    public function jenis_laporan()
    {
        return $this->belongsTo(JenisLaporan::class);
    }

    // Relasi: Laporan memiliki banyak Laporan Tahun
    public function laporan_tahun()
    {
        return $this->hasMany(LaporanTahun::class);
    }
}