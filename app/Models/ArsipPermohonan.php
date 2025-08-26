<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArsipPermohonan extends Model
{
    use SoftDeletes;
    
    protected $table = 'arsip_permohonan';
    protected $guarded = ['id'];
}