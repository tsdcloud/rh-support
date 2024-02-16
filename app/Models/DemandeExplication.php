<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeExplication extends Model
{
    use HasFactory;
    // protected $fillable = [];
    protected $fillable = [
        'initiateur',
        'destinataire',
        'entity_id',
        'motif_id',
        'description',
        'reponse',
        'sent_file_path',
        'answered_file_path',
        'numero_demande_explication',
        'date_incident',
        'date_decharge',
        'date_reponse',
        'file_note_decision_sanction',
        'note_decision_sanction_submit_by',
        'uuid'
    ];

    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    public function destinataires(){
        return $this->belongsTo(User::class, 'destinataire');
    }

    public function emetteur(){
        return $this->belongsTo(User::class, 'initiateur');
    }

    public function piece_jointes(){
        return $this->hasMany(PieceJointe::class);
    }

    public function piece_jointes_reponse(){
        return $this->hasMany(PieceJointeReponse::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function sanction(){
        return $this->hasOne(Sanction::class);
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function reponse_supplementaires(){
        return $this->hasMany(ReponseSupplementaireDe::class);
    }

    public function proposition_sanctions(){
        return $this->hasMany(PropositionSanction::class);
    }

    public function archive(){
        return $this->hasOne(Archive::class);
    }

    public function ontime(){

        $date_reponse = strtotime(now());

        if($this->date_reponse){
            $date_reponse = strtotime($this->date_reponse);
        }

        $created_at = strtotime($this->created_at);

        if(($date_reponse - $created_at) <= 259200){
            return true;
        }

        return false;
    }
    public function late(){

        $date_reponse = strtotime(now());

        if($this->date_reponse){
            $date_reponse = strtotime($this->date_reponse);
        }

        $created_at = strtotime($this->created_at);

        if(($date_reponse - $created_at) > 259200){
            return true;
        }

        return false;
    }
}
