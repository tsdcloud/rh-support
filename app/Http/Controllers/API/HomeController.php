<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DemandeExplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * parameters: tokens
 * code errors:
 * -6 : No authentication
 * -7 : function name is not found
 * -8 : token is empty or is not fullfilled
 * -9 : fonction name is empty (uuid parameter of function)
 */
class HomeController extends Controller
{
    public function index(Request $request){

        $token = $request->header('Authorization');
        $fonction_request = $request->fonction;

        if(!isset($token)){
            return $this->sendError('Echec authentification', [], 400, -8);
        }

        if(!isset($fonction_request)){
            return $this->sendError('Mauvaise requête', [], 400, -9);
        }

        $result = [];
        $nb_de_enattente = null;
        $nb_de_archived = null;
        $de_last = null;

        $personal_access_tokens = DB::table('personal_access_tokens')->where('name', $token)->first();

        if ($personal_access_tokens) {
            $fonction = $this->getFunction($fonction_request);

            if($fonction){
                $user = $this->getUser($personal_access_tokens->tokenable_id);
                $current_user = $user->id;
                $user_entity = $this->getUserEntityFromFunction($fonction->user_entity->uuid);
                $entity_id = $user_entity->entity_id;
                $grade_id = $user_entity->grade_id;

                $nb_users = User::whereHas('user_entity', function($query) use($entity_id){
                    $query->where('entity_id', $entity_id);
                })->count();

                if($user->isAdmin() || $user->isRh()){
                    $nb_de_enattente = DemandeExplication::where(['status'=> false,'entity_id' => $entity_id])->count();
                    $nb_de_archived = DemandeExplication::where(['status'=> true,'entity_id' => $entity_id])->count();
                    $de_lasts = DemandeExplication::where(['status'=> false,'entity_id' => $entity_id])->orderBy('id', 'DESC')->paginate(10);

                }else{
                    $nb_de_enattente = DemandeExplication::where([
                        'status'=> false,
                        'entity_id' => $entity_id,
                        'destinataire' => $user->id
                    ])->orWhere(function($query) use($entity_id, $user){
                        $query->where([
                            'status'=> false,
                            'entity_id' => $entity_id,
                            'initiateur'=> $user->id
                        ]);
                    })->orderBy('id', 'DESC')->count();

                    $nb_de_archived = DemandeExplication::where([
                            'status'=> true,
                            'entity_id' => $entity_id,
                            'destinataire' => $user->id
                        ])->orWhere(function($query) use($entity_id, $user){
                            $query->where([
                                'status'=> true,
                                'entity_id' => $entity_id,
                                'initiateur'=> $user->id
                            ]);
                    })->orderBy('id', 'DESC')->count();


                    $de_lasts = DemandeExplication::where('initiateur', $user->id)->orWhere('destinataire', $user->id)->orWhereHas('destinataires', function($query) use($grade_id){
                        $query->whereHas('user_entity', function($q) use($grade_id){
                            $q->where('grade_id', '<', $grade_id);
                        });
                    })->where(['status'=> true])->orderBy('id', 'DESC')->paginate(10);
                }

                $array_of_lasts_de = [];
                foreach($de_lasts as $key => $de_last){
                    $array_of_lasts_de[$key] = [
                        'name' => $de_last->uuid,
                        'initiateur' => [
                            'name' => $de_last->emetteur->uuid,
                            'fname' => $de_last->emetteur->fname,
                            'lname' => $de_last->emetteur->lname,
                            'email' => $de_last->emetteur->email,
                        ],
                        'destinataire' => [
                            'name' => $de_last->destinataires->uuid,
                            'fname' => $de_last->destinataires->fname,
                            'lname' => $de_last->destinataires->lname,
                            'email' => $de_last->destinataires->email,
                        ],
                        'entity_id' => [
                            'name' => $de_last->entity->uuid,
                            'title' => $de_last->entity->title,
                            'sigle' => $de_last->entity->sigle,
                        ],
                        'status' => $de_last->status,
                        'numero_demande_explication' => $de_last->numero_demande_explication,
                        'date_reponse' => $de_last->date_reponse,
                    ];
                }
                $result = [
                    'token' => $token,
                    'nb_de_enattente' => $nb_de_enattente,
                    'nb_de_archived' => $nb_de_archived,
                    'nb_users' => $nb_users,
                    'de_lasts' => $array_of_lasts_de,
                ];
                return $this->sendResponse($result,'success', 200);
            }else{
                return $this->sendError('Mauvaise requête', [], 400, -7);
            }
        }else{
            return $this->sendError('Echec authentification', [], 400, -6);
        }
    }
}
