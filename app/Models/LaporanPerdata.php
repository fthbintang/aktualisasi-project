<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPerdata extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanPerdataFactory> */
    use HasFactory;

    protected $table = 'laporan_perdata';
    protected $guarded = ['id'];

    public function laporan_perdata_detail(): HasMany
    {
        return $this->hasMany(LaporanPerdataDetail::class);
    }
}