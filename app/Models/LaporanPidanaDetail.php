<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPidanaDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'laporan_pidana_detail';

    public function laporan_pidana(): BelongsTo
    {
        return $this->BelongsTo(LaporanPidana::class);
    }
}