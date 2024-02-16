<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotifOutdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'motif_id',
        'motif_outdate',
        'uuid'
    ];

    public function motif(){
        return $this->belongsTo(Motif::class);
    }
}
