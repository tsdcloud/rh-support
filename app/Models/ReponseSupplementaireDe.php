<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReponseSupplementaireDe extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_explication_id',
        'user_id',
        'initiateur',
        'description',
        'reponse',
        'date_reponse',
        'uuid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function initiateurs(){
        return $this->belongsTo(User::class, 'initiateur');
    }

    public function demandes(){
        return $this->belongsTo(DemandeExplication::class, 'demande_explication_id');
    }

    public function piece_jointes_reponse_supplementaire(){
        return $this->hasMany(PieceJointeReponseSupplementaire::class);
    }
}
