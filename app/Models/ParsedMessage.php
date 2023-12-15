<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParsedMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'parsed_result',
        'direction',
    ];
}
