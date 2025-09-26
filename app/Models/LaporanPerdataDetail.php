<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPerdataDetail extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanPerdataDetailFactory> */
    use HasFactory;

    protected $table = 'laporan_perdata_detail';
    protected $guarded = ['id'];

    public function laporan_perdata()
    {
        return $this->belongsTo(LaporanPerdata::class);
    }
}