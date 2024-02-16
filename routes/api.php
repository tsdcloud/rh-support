<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\DeOperation;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// try{
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('users/infos', [UserController::class, 'users_infos'])->name('users.infos');

    Route::prefix('de')->group(function(){
        Route::get('create', [DeOperation::class, 'create'])->name('de.create');
    });
// }catch(\Exception $e){
//     $response = [
//         'error' => true,
//         'message' => 'Mauvaise requête',
//         // 'code' => $code,
//         'code'=> -10,
//     ];

//     return response()->json($response, 405);
// }
