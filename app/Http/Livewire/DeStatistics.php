<?php

namespace App\Http\Livewire;

use App\Models\DemandeExplication;
use App\Models\Entity;
use App\Models\UserEntity;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
class DeStatistics extends Component
{
    public $activeFilter = true;
    public $entities;
    public $entity;
    public $demande_explications;
    public $emetteurs;
    public $destinataires;

    public $entity_id;
    public $date_debut;
    public $date_fin;
    public $emetteur_id;
    public $destinataire_id;
    public $statut_reponse;

    public $nb_de_with_sanction;
    public $nb_de_with_mapd;
    public $nb_de_without_sanction;
    public $nb_de_order_reminder;
    public $nb_de_initated;
    public $nb_de_not_notified;

    public $nb_de_answered;
    public $nb_de_answered_ontime;
    public $nb_de_answered_late;
    public $nb_de_not_answered;
    public $nb_de_not_answered_ontime;
    public $nb_de_not_answered_late;


    // ["1" => Non répondu]
    // ["2" => Répondu]
    // ["3" => Non répondu, mais dans les delais]
    // ["4" => Non répondu, hors délai]
    // ["5" => Répondu, dans les delais]
    // ["6" => Non répondu, mais hors délais]

    public function mount(){
        $this->entities = Entity::get();

        $this->entity = Entity::first();
        $this->entity_id = $this->entity->id;
        // $this->entity_id = Entity::orderBy('id', 'DESC')->first();

        // dd($this->entity_id);
        $this->emetteurs = User::whereHas('entities', function($query){
            $query->where('entity_id', $this->entity_id);
        })->get();

        $this->destinataires = User::whereHas('entities', function($query){
            $query->where('entity_id', $this->entity_id);
        })->get();

        
        $now = Carbon::now()->locale('ar');
        
        $this->date_debut = $now->subDay(7)->format('d-m-Y');

        $this->statut_reponse = 1; // reponse = null

        $this->initializeVariables();
        $this->functionParameters();

        // if($this->date_fin){
        //     dd($this->date_fin);
        // }
        // initilize variables

        $demandes_explications_answered = DemandeExplication::where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut]
        ])->whereNotNull('reponse')->get();

        foreach($demandes_explications_answered as $demande){
            if($demande->ontime()){
                $this->nb_de_answered_ontime++;
            }else{
                $this->nb_de_answered_late++;
            }
        }
        

        $demandes_explications_not_answered = DemandeExplication::where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut]
        ])->whereNull('reponse')->get();

        foreach($demandes_explications_not_answered as $demande){
            if($demande->ontime()){
                $this->nb_de_not_answered_ontime++;
            }else{
                $this->nb_de_not_answered_late++;
            }
        }
    }

    public function initializeVariables(){
        $this->nb_de_with_sanction = 0;
        $this->nb_de_with_mapd = 0;
        $this->nb_de_without_sanction = 0;
        $this->nb_de_order_reminder = 0;
        $this->nb_de_initated = 0;
        $this->nb_de_not_notified = 0;

        $this->nb_de_answered = 0;
        $this->nb_de_answered_ontime = 0;
        $this->nb_de_answered_late = 0;
        $this->nb_de_not_answered = 0;
        $this->nb_de_not_answered_ontime = 0;
        $this->nb_de_not_answered_late = 0;
    }

    public function functionParameters(){
        $this->nb_de_initated = DemandeExplication::where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut]
        ])->count();

        $this->nb_de_answered = DemandeExplication::where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->whereNotNull('reponse')->count();

        $this->nb_de_not_answered = DemandeExplication::where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->whereNull('reponse')->count();

        $this->nb_de_with_sanction = DemandeExplication::whereHas('sanction')->where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->count();

        $this->nb_de_with_mapd = DemandeExplication::whereHas('sanction', function($query){
            $query->whereBetween('decision',[5,12]); // motifs_sanction_id = [5,12] => mis à pieds de 1 - 8 jours
        })->where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->count();

        $this->nb_de_without_sanction = DemandeExplication::doesntHave('sanction')->where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->count();

        $this->nb_de_order_reminder = DemandeExplication::whereHas('sanction', function($query){
            $query->where('decision',2); // motifs_sanction_id = 2 => rappel a l'ordre
        })->where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->count();

        $this->nb_de_not_notified = DemandeExplication::whereHas('sanction')->where([
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut],
        ])->whereNull('file_note_decision_sanction')->count();
    }
    public function render()
    {
        return view('livewire.de-statistics');
    }

    public function hydrate(){

    }
    public function filterData(){
        $this->activeFilter = false;
        // dd(2);
        $this->initializeVariables();
        $this->functionParameters();

        $data = [
            ['entity_id', $this->entity_id],
            ['created_at','>=', $this->date_debut]
        ];

        if($this->date_fin){
            $data = [
                ['entity_id', $this->entity_id],
                ['created_at','>=', $this->date_debut],
                ['created_at','<=', $this->date_fin]
            ];
        }

        if($this->destinataire_id){
            $data = [
                ['entity_id', $this->entity_id],
                ['created_at','>=', $this->date_debut],
                ['destinataire', $this->destinataire_id]
            ];

            if($this->date_fin){
                $data = [
                    ['entity_id', $this->entity_id],
                    ['created_at','>=', $this->date_debut],
                    ['created_at','<=', $this->date_fin],
                    ['destinataire', $this->destinataire_id]
                ];
            }
        }

        if($this->emetteur_id){
            $data = [
                ['entity_id', $this->entity_id],
                ['created_at','>=', $this->date_debut],
                ['initiateur', $this->emetteur_id]
            ];

            if($this->date_fin){
                $data = [
                    ['entity_id', $this->entity_id],
                    ['created_at','>=', $this->date_debut],
                    ['created_at','<=', $this->date_fin],
                    ['initiateur', $this->emetteur_id]
                ];
            }
        }
        if($this->emetteur_id && $this->destinataire_id){
            $data = [
                ['entity_id', $this->entity_id],
                ['created_at','>=', $this->date_debut],
                ['initiateur', $this->emetteur_id],
                ['destinataire', $this->destinataire_id]
            ];

            if($this->date_fin){
                $data = [
                    ['entity_id', $this->entity_id],
                    ['created_at','>=', $this->date_debut],
                    ['created_at','<=', $this->date_fin],
                    ['initiateur', $this->emetteur_id],
                    ['destinataire', $this->destinataire_id]
                ];
            }
        }
        // 
        $this->nb_de_initated = DemandeExplication::where($data)->count();

        $this->nb_de_answered = DemandeExplication::where($data)->whereNotNull('reponse')->count();

        $this->nb_de_not_answered = DemandeExplication::where($data)->whereNull('reponse')->count();

        $this->nb_de_with_sanction = DemandeExplication::whereHas('sanction')->where($data)->count();

        $this->nb_de_with_mapd = DemandeExplication::whereHas('sanction', function($query){
            $query->whereBetween('decision',[5,12]); // motifs_sanction_id = [5,12] => mis à pieds de 1 - 8 jours
        })->where($data)->count();

        $this->nb_de_without_sanction = DemandeExplication::doesntHave('sanction')->where($data)->count();

        $this->nb_de_order_reminder = DemandeExplication::whereHas('sanction', function($query){
            $query->where('decision',2); // motifs_sanction_id = 2 => rappel a l'ordre
        })->where($data)->count();

        $this->nb_de_not_notified = DemandeExplication::whereHas('sanction')->where($data)->whereNull('file_note_decision_sanction')->count();
        // 

        $demandes_explications_answered = DemandeExplication::where($data)->whereNotNull('reponse')->get();

        foreach($demandes_explications_answered as $demande){
            if($demande->ontime()){
                $this->nb_de_answered_ontime++;
            }else{
                $this->nb_de_answered_late++;
            }
        }

        $demandes_explications_not_answered = DemandeExplication::where($data)->whereNull('reponse')->get();

        foreach($demandes_explications_not_answered as $demande){
            if($demande->ontime()){
                $this->nb_de_not_answered_ontime++;
            }else{
                $this->nb_de_not_answered_late++;
            }
        }
    }
}
