<?php

namespace App\Http\Controllers;

use App\Models\DemandeExplication;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // update_all_tables_uuid();

        $current_user = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $users = User::whereHas('user_entity', function($query) use($current_entity_id){
            $query->where('entity_id', $current_entity_id);
        })->count();
        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $de_enattente = DemandeExplication::where(['status'=> false,'entity_id' => auth()->user()->current_user_entity()->entity_id])->count();
            $de_archived = DemandeExplication::where(['status'=> true,'entity_id' => auth()->user()->current_user_entity()->entity_id])->count();
            $de_lasts = DemandeExplication::where(['status'=> false,'entity_id' => auth()->user()->current_user_entity()->entity_id])->orderBy('id', 'DESC')->paginate(10);
        }else{
            // dump(auth()->user()->current_user_entity()->grade_id);
            $de_enattente = DemandeExplication::where([
                'status'=> false,
                'entity_id' => $current_entity_id,
                'destinataire' => auth()->user()->id
            ])->orWhere(function($query) use($current_entity_id){
                $query->where([
                    'status'=> false,
                    'entity_id' => $current_entity_id,
                    'initiateur'=> auth()->user()->id
                ]);
            })->orderBy('id', 'DESC')->count();

            $de_archived = DemandeExplication::where([
                    'status'=> true,
                    'entity_id' => $current_entity_id,
                    'destinataire' => auth()->user()->id
                ])->orWhere(function($query) use($current_entity_id){
                    $query->where([
                        'status'=> true,
                        'entity_id' => $current_entity_id,
                        'initiateur'=> auth()->user()->id
                    ]);
            })->orderBy('id', 'DESC')->count();


            $de_lasts = DemandeExplication::where('initiateur', auth()->user()->id)->orWhere('destinataire', auth()->user()->id)->orWhereHas('destinataires', function($query){
                $query->whereHas('user_entity', function($q){
                    $q->where('grade_id', '<', auth()->user()->current_user_entity()->grade_id);
                });
            })->where(['status'=> true])->orderBy('id', 'DESC')->paginate(10);
        }

        // dd($de_lasts);
        return view('home', compact('de_lasts', 'de_enattente', 'de_archived', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
