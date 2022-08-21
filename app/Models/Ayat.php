<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{
    use HasFactory;

    protected $table = "ayat";

    protected $fillable = [
        "id",
        "arabic",
        "translation",
        "nomor",
        "latin",
        "idSurah",
    ];

    public $incrementing = false;
}
