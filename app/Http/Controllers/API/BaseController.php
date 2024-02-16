<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'error' => false,
            'data'    => $result,
            'message' => $message,
            'hasManyEntities' => false
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
}
