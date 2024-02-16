<?php

namespace App\Http\Livewire;

use App\Models\Entity;
use App\Models\User;
use Livewire\Component;

class DeToTransfered extends Component
{
    public $destinataires;
    public $destinataire;
    
    public $motifs;
    public $entities;
    public $initiateurs;

    public $entity_id;

    public function mount($motifs){
        $this->motifs = $motifs;
        
        $this->entities = Entity::where('id','!=',auth()->user()->current_user_entity()->entity_id)->get();
        // dd($this->entities);
        $this->destinataires = [];
        // $this->destinataires = User::whereHas('');
    }

    public function render()
    {
        return view('livewire.de-to-transfered');
    }

    public function changeEntity(){
        $this->destinataires = User::whereHas('user_entity', function($query){
            $query->where('entity_id', $this->entity_id)->where('grade_id','<=',auth()->user()->current_user_entity()->grade_id);
        })->get();

        dump($this->destinataires);
    }

    public function getDestinataire(){
        $initiateurs = 
        $this->initiateurs = User::whereHas('user_entity', function($query){
            $query->where('entity_id', $this->entity_id)->where('grade_id','<=',auth()->user()->current_user_entity()->grade_id);
        })->get();
    }
}
