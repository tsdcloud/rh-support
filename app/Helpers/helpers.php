<?php

use App\Models\Archive;
use App\Models\Category;
use App\Models\DecideurSanction;
use App\Models\DemandeExplication;
use App\Models\Department;
use App\Models\Echelon;
use App\Models\Entity;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\Inscription;
use App\Models\Motif;
use App\Models\MotifOutdate;
use App\Models\MotifSanction;
use App\Models\Notification;
use App\Models\Operation;
use App\Models\PieceJointe;
use App\Models\PieceJointeReponse;
use App\Models\Privilege;
use App\Models\PropositionSanction;
use App\Models\ReponseSupplementaireDe;
use App\Models\Role;
use App\Models\Sanction;
use App\Models\User;
use App\Models\UserEntity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

function setMenuActive($route){
    $routeActuel = request()->route()->getName();

    if($routeActuel === $route){

        return 'active';
    }
    if(isContained($routeActuel, $route)){
        return 'active';
    }
    return "";
}

function stringToLowercase($value){
    return Str::of($value)->lower();
}

function isContained($container, $content){
    return Str::contains($container, $content);
}

function listOfPrivileges($lists){
    $list = "";
    $number_of_privilege = count($lists);

    foreach ($lists as $selfprivilege){
        $list = $list . $selfprivilege->name_of_privilege;

        if($number_of_privilege > 1){
            $list = $list . "; ";
        }

        $number_of_privilege --;
    }
    return $list;
}

function setDate($dateInput){
    if($dateInput){
        $date = Carbon::parse($dateInput, 'UTC');
        return $date->isoFormat('MMMM Do YYYY, h:mm:ss a');
    }
}

function changeDateFormat($date){

    // $date = Carbon::createFromIsoFormat('!YYYY-MMMM-D h:mm:ss a', '2019-January-3 6:33:24 pm', 'UTC');
    // echo $date->isoFormat('M/D/YY HH:mm');

    $date = Carbon::parse($date, 'UTC');

    return $date->isoFormat('d/m/Y à HH:mm');
}

function getEntity($fonction_id){

    if(!session()->has('fonction_id')){
        return route('login');
    }

    $fonction = Fonction::find($fonction_id['fonction_id']);
    return $fonction->fonction;
}

function getEntityImg($fonction_id){
    if(!session()->has('fonction_id')){
        return route('login');
    }
    $fonction = Fonction::find($fonction_id['fonction_id']);

    return $fonction->user_entity->entity->logo;
}

function getFunctions($fonction_id){
    $fonction = Fonction::find($fonction_id['fonction_id']);

    return Fonction::where(['user_entity_id' => $fonction->user_entity_id])->get();
}

function checkPropositionSanction($user_id, $demande_explication_id){
    return PropositionSanction::where([
        'user_id' => $user_id,
        'demande_explication_id' => $demande_explication_id
    ])->first();
}

function checkDecisionSanction($demande_explication_id){
    return Sanction::where('demande_explication_id',$demande_explication_id)->first();
}

function getDecideurSanctionDE(){
    return User::has('decision_sanction')->get();
}

// function checkReponsesSupplementaires($demande, $notification){

//     foreach($demande->reponse_supplementaires as $reponse){
//         if(empty($reponse)){
//             return true;
//         }
//     }

//     return false;
// }

function reponses_supplementaires($demande){
    // dump($demande);
    $isShowable = false;
    $demandes = ReponseSupplementaireDe::where('demande_explication_id', $demande->id)->get();

    foreach($demandes as $reponse_supplementaires){
        $isShowable = false;
        // 172800
        if(($reponse_supplementaires->reponse) || (strtotime($reponse_supplementaires->date_reponse) - strtotime($reponse_supplementaires->created_at)) >= 172800){
            $isShowable = true;
        }
    }

    return $isShowable;
}
function update_all_tables_uuid(){
    foreach(Archive::all() as $archive){
        $archive->uuid = (string) Uuid::uuid4();
        $archive->save();
    }
    foreach(Category::all() as $category){
        $category->uuid = (string) Uuid::uuid4();
        $category->save();
    }
    foreach(DecideurSanction::all() as $decideur){
        $decideur->uuid = (string) Uuid::uuid4();
        $decideur->save();
    }
    foreach(DemandeExplication::all() as $demande_explication){
        $demande_explication->uuid = (string) Uuid::uuid4();
        $demande_explication->save();
    }
    foreach(Department::all() as $department){
        $department->uuid = (string) Uuid::uuid4();
        $department->save();
    }
    foreach(Echelon::all() as $echelon){
        $echelon->uuid = (string) Uuid::uuid4();
        $echelon->save();
    }
    foreach(Entity::all() as $entity){
        $entity->uuid = (string) Uuid::uuid4();
        $entity->save();
    }
    foreach(Fonction::all() as $fonction){
        $fonction->uuid = (string) Uuid::uuid4();
        $fonction->save();
    }
    foreach(Grade::all() as $grade){
        $grade->uuid = (string) Uuid::uuid4();
        $grade->save();
    }
    foreach(Motif::all() as $motif){
        $motif->uuid = (string) Uuid::uuid4();
        $motif->save();
    }
    foreach(MotifOutdate::all() as $motif_outdate){
        $motif_outdate->uuid = (string) Uuid::uuid4();
        $motif_outdate->save();
    }
    foreach(MotifSanction::all() as $motif_sanction){
        $motif_sanction->uuid = (string) Uuid::uuid4();
        $motif_sanction->save();
    }
    foreach(Notification::all() as $notification){
        $notification->uuid = (string) Uuid::uuid4();
        $notification->save();
    }
    foreach(Operation::all() as $operation){
        $operation->uuid = (string) Uuid::uuid4();
        $operation->save();
    }
    foreach(PieceJointe::all() as $piece_jointe){
        $piece_jointe->uuid = (string) Uuid::uuid4();
        $piece_jointe->save();
    }
    foreach(PieceJointeReponse::all() as $piece_jointe_reponse){
        $piece_jointe_reponse->uuid = (string) Uuid::uuid4();
        $piece_jointe_reponse->save();
    }
    foreach(Privilege::all() as $privilege){
        $privilege->uuid = (string) Uuid::uuid4();
        $privilege->save();
    }
    foreach(PropositionSanction::all() as $proposition_sanction){
        $proposition_sanction->uuid = (string) Uuid::uuid4();
        $proposition_sanction->save();
    }
    foreach(ReponseSupplementaireDe::all() as $reponse_supplementaire_de){
        $reponse_supplementaire_de->uuid = (string) Uuid::uuid4();
        $reponse_supplementaire_de->save();
    }
    foreach(Role::all() as $role){
        $role->uuid = (string) Uuid::uuid4();
        $role->save();
    }
    foreach(Sanction::all() as $sanction){
        $sanction->uuid = (string) Uuid::uuid4();
        $sanction->save();
    }
    foreach(User::all() as $user){
        $user->uuid = (string) Uuid::uuid4();
        $user->save();
    }
    foreach(UserEntity::all() as $user_entity){
        $user_entity->uuid = (string) Uuid::uuid4();
        $user_entity->save();
    }
}

function isFunctionExist($function_uuid){
    return Fonction::where('uuid', $function_uuid)->exists();
}
