<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class PiecesJointesInput extends Component
{
    use WithFileUploads;

    public $pieces_jointe = [];
    public $nbr_file = 0;

    public function render()
    {
        return view('livewire.pieces-jointes-input');
    }

    public function hydrate(){

    }

    public function updatedPiecesJointe(){
        // try{
            $this->validate([
                'pieces_jointe.*' => 'image|mimes:png,gif,bmp,svg,wav,mp4,mov,avi,wmv,mp3,m4a,jpeg,jpg,mpga,webp,wma', // 1MB Max
                // 'pieces_jointe.*' => 'image|max:4096|mimes:png,gif,bmp,svg,wav,mp4,mov,avi,wmv,mp3,m4a,jpeg,jpg,mpga,webp,wma', // 1MB Max
            ],[
               'pieces_jointe.*.image' => 'Les pièces jointes doivent être des images',
               'pieces_jointe.*.max' => 'Les pièces jointes doivent être des images'
            ]);
        // }catch(\Exception $e){

        // }
    }
    public function save()
    {
        // ...
    }
}
