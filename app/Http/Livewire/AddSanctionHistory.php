<?php

namespace App\Http\Livewire;

use App\Models\Motif;
use App\Models\MotifOutdate;
use App\Models\MotifSanction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddSanctionHistory extends Component
{
    public function mount(){
        $this->users = User::all();
        $this->motifs = Motif::all();

        $this->motif_sanctions = MotifSanction::all();
    }
    public function render()
    {
        return view('livewire.add-sanction-history');
    }
}
