<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadLaporan extends Model
{
    use HasFactory;

    protected $table = 'upload_laporan';
    protected $guarded = ['id'];

    // Relasi: Upload Laporan milik Laporan Tahun
    public function laporan_tahun()
    {
        return $this->belongsTo(LaporanTahun::class);
    }

}