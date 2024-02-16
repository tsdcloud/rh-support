<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RemoveUserPrivilege extends Component
{
    public $user_id;
    public $privilege_id;
    
    public function mount($user_id,$privilege_id){
        $this->user_id = $user_id;
        $this->privilege_id = $privilege_id;
    }
    public function render()
    {
        return view('livewire.remove-user-privilege');
    }
}
