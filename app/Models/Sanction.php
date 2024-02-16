<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'decision',
        'user_id',
        'demande_explication_id',
        'decideur',
        'motif_outdate_id',
        'description',
        'uuid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function decideurs(){
        return $this->belongsTo(User::class, 'decideur');
    }

    public function demande(){
        return $this->belongsTo(DemandeExplication::class, 'demande_explication_id');
    }

    public function decisions(){
        return $this->belongsTo(MotifSanction::class, 'decision');
    }

    public function motif_outdate(){
        return $this->belongsTo(MotifOutdate::class);
    }
}
