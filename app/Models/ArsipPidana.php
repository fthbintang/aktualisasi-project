<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArsipPidana extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'arsip_pidana';
    protected $guarded = ['id'];
}