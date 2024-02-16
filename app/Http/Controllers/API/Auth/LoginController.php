<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        // $baseController = new BaseController();
        $json = file_get_contents('php://input');

        try{
            // Converts it into a PHP object
            $data = json_decode($json, true);

            // check empty string
            if(isset($data['email']) && isset($data['password'])){
                // check data validation
                $validator = Validator::make($data, [
                    'email'=>'email'
                ]);

                if($validator->fails()){
                    return $this->sendError('Echec authentification', [], 400, -2);
                }

                // check email exists
                if(User::where('email', '=', $data['email'])->exists()){
                    // check correct email and password
                    if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                        $user = Auth::user();
                        $success['token'] =  $user->createToken(Str::random(60))->accessToken;
                        $success['token'] = [
                            "name" => $success['token']["name"],
                            "abilities" => $success['token']["abilities"],
                            "expires_at" => $success['token']["expires_at"]
                        ];

                        $success['user'] =  [
                            "fname" => $user->fname,
                            "lname" => $user->lname,
                            "phone" => $user->phone,
                            "email" => $user->email,
                            "email_verified_at" => $user->email_verified_at,
                            "created_at" => $user->created_at,
                        ];
                        $success['user']['hasManyEntities'] = false;
                        $user_entities = auth()->user()->user_entity;
                        if(count($user_entities) > 1){
                            $success['user']['hasManyEntities'] = true;
                        }


                        foreach($user_entities as $k => $user_entity) {
                            $success['entities'][$k] = [
                                "user_entity" => $user_entity->uuid,
                                "entity" => [
                                    'name' => $user_entity->entity->uuid,
                                    'title' => $user_entity->entity->title,
                                    'sigle' => $user_entity->entity->sigle,
                                ],
                                // "grade" =>[
                                //     'name' => $user_entity->grade->uuid,
                                //     'title' => $user_entity->entity->title,
                                // ],
                            ];
                            $fonctions = $user_entity->fonctions;

                            foreach ($fonctions as $q => $fonction) {
                                $success['entities'][$k]['fonctions'][$q] = [
                                    'name' => $fonction->uuid,
                                    "fonction" => $fonction->fonction,
                                    "user_entity" => $user_entity->uuid,
                                    "department" => $fonction->department->uuid,
                                    "category" => $fonction->category->uuid,
                                    "echelon" => $fonction->echelon->uuid,
                                    "created_at" => $fonction->created_at,
                                ];
                            }
                        }

                        return $this->sendResponse($success, 'Authentification réussie');
                    }
                    else{
                        return $this->sendError('Echec authentification', [], 400, -1);
                    }
                }else{
                    return $this->sendError('Echec authentification', [], 400, -3);
                }

            }else{
                return $this->sendError('Echec authentification', [], 400, -4);
            }
        }catch(\Exception $e){
            return $this->sendError('Echec authentification', [], 400, -5);
        }
    }
}
