<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyatIndopak extends Model
{
    use HasFactory;

    protected $table = "ayat_indopak";

    protected $fillable = [
        "id",
        "arabic",
    ];

    public $incrementing = false;
}
