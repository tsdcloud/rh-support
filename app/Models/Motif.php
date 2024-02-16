<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    use HasFactory;

    protected $fillable = [
        'motif',
        'uuid'
    ];

    public function motif_outdate(){
        return $this->hasMany(MotifOutdate::class);
    }
}
