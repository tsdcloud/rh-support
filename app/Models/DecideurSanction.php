<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecideurSanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'decision_sur',
        'entity_id',
        'uuid'
    ];


}
