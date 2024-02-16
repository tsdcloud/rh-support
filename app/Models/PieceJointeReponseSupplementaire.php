<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointeReponseSupplementaire extends Model
{
    use HasFactory;
    protected $fillable =[
        'piece_jointe',
        'demande_explication_id',
        'uuid'
    ];
}
