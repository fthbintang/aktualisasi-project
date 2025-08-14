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

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}