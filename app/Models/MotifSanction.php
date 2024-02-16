<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotifSanction extends Model
{
    use HasFactory;

    protected $fillable =[
        'motif',
        'uuid'
    ];
}
