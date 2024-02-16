<?php

namespace App\Http\Controllers;

use App\Models\DemandeExplication;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;

class StatisticsController extends Controller
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

    public function explanation_demand(){
        return view('statistics.explanation_demand');
    }

    public function explanation_demand_store(Request $request){

        $data = $request->validate([
            'date_debut' => 'required',
            // 'date_fin' => 'after_or_equal:date_debut'
        ]);
        $demande_explications = DemandeExplication::whereBetween('created_at', [$data['date_debut'],now()])->get();
        
        if($request->date_fin){
            $request->validate([
                'date_fin' => 'after_or_equal:date_debut'
            ]);
                
            $data['date_fin'] = $request->date_fin;
            $demande_explications = DemandeExplication::whereBetween('created_at', [$data['date_debut'],$data['date_fin']])->get();
        }

        $line[] = [];
        $k = 0;
        foreach($demande_explications as $demande_explication){
            $line[$k]['N°'] = $k + 1;
            $line[$k]['Accusé'] = $demande_explication->destinataires->fname . ' ' . $demande_explication->destinataires->lname;
            $line[$k]['N° de DE'] = $demande_explication->numero_demande_explication;
            $line[$k]['Initiateur'] = $demande_explication->emetteur->fname . ' ' . $demande_explication->emetteur->lname;
            $line[$k]['Motif'] = $demande_explication->motif->motif;
            $line[$k]['Date de la DE'] = $demande_explication->created_at;
            $line[$k]['Heure de la DE'] = $demande_explication->created_at;
            
            if($demande_explication->reponse){
                $line[$k]['Statut de réponse'] = 'Répondu';
                $line[$k]['Date de réponse'] = $demande_explication->date_reponse;
                $line[$k]['Heure de réponse'] = $demande_explication->date_reponse;
            }else{
                $line[$k]['Statut de réponse'] = 'Non répondu';
                $line[$k]['Date de réponse'] = '-';
                $line[$k]['Heure de réponse'] = '-';
            }
            
            if($demande_explication->sanction){
                $line[$k]['Décision de sanction'] = $demande_explication->sanction->decisions->motif;
                $line[$k]['Décidée par'] = $demande_explication->sanction->decideurs->fname . ' ' . $demande_explication->sanction->decideurs->lname;
                // dump($demande_explication->sanction->decisions->motif);
                // dd(1);
            }
            else{
                $line[$k]['Décision de sanction'] = 'Aucune de décision prise';
                // dump($demande_explication->sanction);
                $line[$k]['Décidée par'] = '-';
            }

            $line[$k]['Entité'] = $demande_explication->entity->sigle;
            $k++;
        }

        // dd(2);
        $date = date('m-d-Y H:m:i');

        $writer = SimpleExcelWriter::streamDownload('explanation_demand_export_'. $date .'.xlsx')
        ->addRows($line);
    }

    public function explanation_specific_demand(Request $request){

        // dd($request->all());
        $data = $request->validate([
            'date_debut' => 'required',
            // 'date_fin' => 'after_or_equal:date_debut'
        ]);
        $demande_explications = DemandeExplication::whereBetween('created_at', [$data['date_debut'],now()])->get();
        
        if($request->date_fin){
            $request->validate([
                'date_fin' => 'after_or_equal:date_debut'
            ]);
                
            $data['date_fin'] = $request->date_fin;
            $demande_explications = DemandeExplication::whereBetween('created_at', [$data['date_debut'],$data['date_fin']])->get();
        }

        $line[] = [];
        $k = 0;
        foreach($demande_explications as $demande_explication){
            $line[$k]['N°'] = $k + 1;
            $line[$k]['Accusé'] = $demande_explication->destinataires->fname . ' ' . $demande_explication->destinataires->lname;
            $line[$k]['N° de DE'] = $demande_explication->numero_demande_explication;
            $line[$k]['Initiateur'] = $demande_explication->emetteur->fname . ' ' . $demande_explication->emetteur->lname;
            $line[$k]['Motif'] = $demande_explication->motif->motif;
            $line[$k]['Date de la DE'] = $demande_explication->created_at;
            $line[$k]['Heure de la DE'] = $demande_explication->created_at;

            // S'il faut la description
            if($request->with_description){
                $line[$k]['Description'] = preg_replace('#<br\s*/?>#i', "\n", $demande_explication->description);
            }

            if($request->with_answers){
                $line[$k]['Réponse'] = preg_replace('#<br\s*/?>#i', "\n", $demande_explication->reponse);
            }
            
            if($demande_explication->reponse){
                $line[$k]['Statut de réponse'] = 'Répondu';
                $line[$k]['Date de réponse'] = $demande_explication->date_reponse;

                if((strtotime($demande_explication->date_reponse) - strtotime($demande_explication->created_at)) <= 259200){
                    $line[$k]['Delais'] = 'Dans les delais';
                }else{
                    $line[$k]['Delais'] = 'Hors delais';
                }
            }else{
                $line[$k]['Statut de réponse'] = 'Non répondu';
                $line[$k]['Date de réponse'] = '-';

                if((strtotime(now()) - strtotime($demande_explication->created_at)) <= 259200){
                    $line[$k]['Delais'] = 'Dans les delais';
                }else{
                    $line[$k]['Delais'] = 'Hors delais';
                }
            }
            
            if($demande_explication->sanction){
                $line[$k]['Décision de sanction'] = $demande_explication->sanction->decisions->motif;
                $line[$k]['Décidée par'] = $demande_explication->sanction->decideurs->fname . ' ' . $demande_explication->sanction->decideurs->lname;
                // dump($demande_explication->sanction->decisions->motif);
                // dd(1);

                if($request->status_note_sanction){
                    if($demande_explication->file_note_decision_sanction){
                        $line[$k]['Note de décision'] = 'Envoyée';
                        $line[$k]['Date de notification'] = $demande_explication->updated_at;
                    }else{
                        $line[$k]['Note de décision'] = 'Non envoyée';
                        $line[$k]['Date de notification'] = '-';
                    }
                }
            }
            else{
                $line[$k]['Décision de sanction'] = 'Aucune décision prise';
                $line[$k]['Décidée par'] = '-';

                $line[$k]['Note de décision'] = 'Pas de note';
                $line[$k]['Date de notification'] = '-';
            }

            $line[$k]['Entité'] = $demande_explication->entity->sigle;
            $k++;
        }

        $date = date('m-d-Y H:m:i');

        $writer = SimpleExcelWriter::streamDownload('explanation_demand_export_'. $date .'.xlsx')
        ->addRows($line);
    }

    public function statistics_rh(){
        return  view('statistics.rh');
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
