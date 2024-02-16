<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use App\Models\User;
use App\Models\UserEntity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'error' => false,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    /**
     * parameters
     * general error description
     * list of error
     * standard code error
     * error for debugging
     * ----------------------------------------
    * return error response.
    * -1 => Email or password incorrect (default)
    * -2 => Incorrect email format; must be formatted as email@domain.com
    * -3 => Email not exists
    * -4 => Email or Password is empty
    * -5 => Incorrect data format; json is required
    * -6 : No authentication
    * -7 : function name is not found
    * -8 : token is empty or is not fullfilled
    * -9 : fonction name is empty (uuid parameter of function)
    * -10 : Exception not preview/ probably internal server error
    * @return \Illuminate\Http\Response
    */

    public function sendError($error, $errorMessages = [], $code = 400, $code_debug = -1)
    {
        $response = [
            'error' => true,
            'message' => $error,
            // 'code' => $code,
            'code'=>$code_debug,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function getFunction($function_uuid){
        return Fonction::where('uuid', $function_uuid)->first();
    }
    public function getUser($tokenable_id){
        return User::find($tokenable_id);
    }
    public function getUserEntityFromFunction($fonction){
        return UserEntity::where('uuid', $fonction)->first();
    }
}
