<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    protected $fillable =[
        'fonction',
        'user_entity_id',
        'category_id',
        'echelon_id',
        'department_id',
        'uuid'
    ];

    public function user_entity(){
        return $this->belongsTo(UserEntity::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function echelon(){
        return $this->belongsTo(Echelon::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
