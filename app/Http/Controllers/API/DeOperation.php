<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fonction;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeOperation extends Controller
{
    public function create(Request $request){

        $token = $request->header('Authorization');
        $fonction_request = $request->header('fonction');

        if(!isset($token)){
            return $this->sendError('Echec authentification', [], 404, -8);
        }

        if(!isset($fonction_request)){
            return $this->sendError('Fonction non trouvée', [], 404, -9);
        }

        $personal_access_tokens = DB::table('personal_access_tokens')->where('name', $token)->first();
        if ($personal_access_tokens) {
            $fonction = $this->getFunction($fonction_request);

            if($fonction){
                $user = $this->getUser($personal_access_tokens->tokenable_id);
                $current_user = $user->id;
                $user_entity = $this->getUserEntityFromFunction($fonction->user_entity->uuid);
                $entity_id = $user_entity->entity_id;
                $grade_id = $user_entity->grade_id;

                $destinataires = User::whereRelation('user_entity', 'grade_id', '<=', $grade_id)
                            ->whereRelation('user_entity', 'entity_id', '=', $entity_id)
                            ->where('id', '!=', $current_user)->where('deleted',false)->get();

                $motifs = Motif::orderBy('motif', 'ASC')->get();

                $array_of_destinataires = [];
                foreach($destinataires as $key => $destinataire){
                    $array_of_destinataires[$key] = [
                        "name" => $destinataire->uuid,
                        "fname" => $destinataire->fname,
                        "lname" => $destinataire->lname,
                        "email" => $destinataire->email,
                    ];
                }

                $array_of_motifs = [];
                foreach($motifs as $key => $motif){
                    $array_of_motifs[$key] = [
                        "name" => $motif->uuid,
                        "motif" => $motif->motif
                    ];
                }

                $result = [
                    'token' => $token,
                    'destinataires' => $array_of_destinataires,
                    'motifs' => $array_of_motifs,
                ];
                return $this->sendResponse($result,'success', 200);
            }else{
                return $this->sendError('Fonction non trouvée.', [], 404, -7);
            }
        }else{
            return $this->sendError('Echec authentification', [], 404, -6);
        }
    }
}
