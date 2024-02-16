<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointePropositionSanction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'piece_jointe',
        'proposition_sanction_id'
    ];
}
