<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keterangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_keterangan',
    ];
}
