<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropositionSanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'proposition_sanction',
        'user_id',
        'sanction_id',
        'demande_explication_id',
        'description',
        'uuid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function proposition(){
        return $this->belongsTo(MotifSanction::class, 'proposition_sanction');
    }
    
    public function piece_jointes_proposition_sanctions(){
        return $this->hasMany(PieceJointePropositionSanction::class);
    }
}
