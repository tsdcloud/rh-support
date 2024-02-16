<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class TeleverserNoteDecisionSanction extends Component
{
    use WithFileUploads;
    
    public $note_decision_sanction = [];
    public $nbr_file = 0;
    public $demande;

    public function mount($demande){
        $this->demande = $demande;
    }

    public function render()
    {
        return view('livewire.televerser-note-decision-sanction');
    }

    public function hydrate(){

    }

    public function getFile(){

        // dd(2);
        // $this->nbr_file = count($this->note_decision_sanction);

        // return $this->nbr_file;
    }
}
