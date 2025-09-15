<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArsipGugatan extends Model
{
    use HasFactory;

    protected $table = 'arsip_gugatan';
    protected $guarded = ['id'];
}