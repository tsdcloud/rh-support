<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function users_infos(Request $request){
        try{

            $token = $request->header('Authorization');

            if(!isset($token)){
                return $this->sendError('Echec authentification', [], 400, -8);
            }

            $personal_access_tokens = DB::table('personal_access_tokens')->where('name', $token)->first();

            if ($personal_access_tokens) {
                $user = User::find($personal_access_tokens->tokenable_id);
                $data = [];

                $data['user'] = [
                    'name' => $user->uuid,
                    'fname' => $user->fname,
                    'lname' => $user->lname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ];
                foreach($user->user_entity as $key => $user_entity){
                    $data['entities'][$key] = [
                        'name' => $user_entity->entity->uuid,
                        'title' => $user_entity->entity->title,
                        'sigle' => $user_entity->entity->sigle,
                    ];

                    foreach($user_entity->fonctions as $new_key => $fonction){
                        $data['entities'][$key]['fonctions'][$new_key] = [
                            'name' => $fonction->uuid,
                            'fonction' => $fonction->fonction,
                        ];
                    }
                }

                return response()->json($data, 200);

            }else{
                return $this->sendError('Echec authentification', [], 400, -6);
            }
        }catch(\Exception $e){
            return $this->sendError('Echec authentification', [], 400, -10);
        }
    }
}
