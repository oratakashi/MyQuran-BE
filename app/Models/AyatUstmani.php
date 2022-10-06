<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyatUstmani extends Model
{
    use HasFactory;

    protected $table = "ayat_ustmani";

    protected $fillable = [
        "id",
        "arabic",
    ];

    public $incrementing = false;
}
