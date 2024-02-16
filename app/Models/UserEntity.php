<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEntity extends Model
{
    use HasFactory;

    protected $table = 'user_entities';
    protected $fillable = [
        'user_id',
        'grade_id',
        'entity_id',
        'uuid'
    ];

    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function fonctions(){
        return $this->hasMany(Fonction::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class);
    }
}
