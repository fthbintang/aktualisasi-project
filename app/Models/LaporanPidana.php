<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPidana extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'laporan_pidana';

    public function laporan_pidana_detail(): HasMany
    {
        return $this->hasMany(LaporanPidanaDetail::class);
    }
}