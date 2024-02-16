<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'phone',
        'email',
        'password',
        'deleted',
        'uuid'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $isAdmin = false;
    public $isRh = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_entity(){
        return $this->hasMany(UserEntity::class);
    }

    public function entities(){
        return $this->hasMany(UserEntity::class);
    }

    public function current_user_entity(){

        return Fonction::find(session('fonction_id')['fonction_id'])->user_entity;

    }

    public function has_received_de(){
        return $this->hasMany(DemandeExplication::class, 'destinataire');
    }

    public function demandes(){
        return $this->hasMany(DemandeExplication::class, 'destinataire');
    }

    public function sanctions(){
        return $this->hasMany(Sanction::class);
    }

    public function decision_sanction(){
        return $this->hasOne(DecideurSanction::class)->where('decision_sur', 'demande_explication');
    }

    public function isDecideurSanction(){
        // dd($this->id);
        return DecideurSanction::where([
            'decision_sur'=> 'demande_explication',
            'user_id'=> $this->id,
        ])->exists();
    }

    public function is_super_admin(){
        return false;
    }

    public function privileges(){
        return $this->hasMany(Privilege::class);
    }

    public function isAdmin(){
        foreach($this->privileges as $privilege){
            if($privilege->role->title == 'admin'){
                $this->isAdmin = true;
            }
        }
        return $this->isAdmin;
    }

    public function isRh(){
        foreach($this->privileges as $privilege){
            if($privilege->role->title == 'rh'){
                $this->isRh = true;
            }
        }
        return $this->isRh;
    }
}
