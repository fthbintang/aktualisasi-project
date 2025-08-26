<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTahun extends Model
{
    use HasFactory;
    
    protected $table = 'laporan_tahun';
    protected $guarded = ['id'];

    // Relasi: Laporan Tahun milik Laporan
    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    // Relasi: Laporan Tahun memiliki banyak Upload Laporan
    public function upload_laporan()
    {
        return $this->hasMany(UploadLaporan::class);
    }
}