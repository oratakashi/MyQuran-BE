<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $table = "surah";

    protected $fillable = [
        'nama',
        'rukuk',
        'urut',
        'keterangan',
        'arti',
        'asma',
        'audio',
        'type',
        'ayat',
        'id',
    ];
}
