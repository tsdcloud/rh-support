<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
        'demande_explication_id',
        'user_id',
        'motif',
        'uuid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
