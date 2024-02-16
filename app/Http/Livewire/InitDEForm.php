<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InitDEForm extends Component
{
    public $destinataires;
    public $motifs;

    public function mount($destinataires, $motifs){
        $this->destinataires = $destinataires;
        $this->motifs = $motifs;
    }

    public function render()
    {
        return view('livewire.init-d-e-form');
    }
}
