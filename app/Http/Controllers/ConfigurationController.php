<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use App\Models\MotifSanction;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function motifs(){
        $motifs = Motif::all();
        return view('configurations.motifs_de', compact('motifs'));
    }
    public function motifs_store(Request $request){
        $request->validate([
            'motif' => 'required'
        ]);

        Motif::create([
            'motif' => $request->motif
        ]);

        alert()->success('Opération réussie','Motif ajouté avec succès');
        return back()->with('success', 'Motif ajouté avec succès');
    }

    public function motifs_update(Request $request, Motif $motif){
        $request->validate([
            'motif' => 'required'
        ]);

        $motif->update([
            'motif' => $request->motif
        ]);

        alert()->success('Opération réussie','Motif mis à jour avec succès');
        return back()->with('success', 'Motif mis à jour avec succès');
    }

    public function sanction(){
        $sanctions = MotifSanction::all();
        return view('configurations.motifs_sanction', compact('sanctions'));
    }

    public function sanction_store(Request $request){
        $request->validate([
            'motif' => 'required'
        ]);

        MotifSanction::create([
            'motif' => $request->motif
        ]);

        alert()->success('Opération réussie','Motif ajouté avec succès');
        return back()->with('success', 'Motif ajouté avec succès');
    }

    public function sanction_update(Request $request, MotifSanction $motif){
        
        $request->validate([
            'motif' => 'required'
        ]);

        $motif->update([
            'motif' => $request->motif
        ]);
        
        alert()->success('Opération réussie','Motif mis à jour avec succès');
        return back()->with('success', 'Motif mis à jour avec succès');
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
