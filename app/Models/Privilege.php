<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'entity_id',
        'uuid'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function entity(){
        return $this->belongsTo(Entity::class);
    }
}
