<?php

namespace App\Http\Controllers;

use App\Jobs\DecisionSanctionJob;
use App\Mail\DecisionSanctionMail;
use App\Mail\DecisionSanctionRhMail;
use App\Mail\NoteDecisionSanctionMail;
use App\Mail\PropositionSanctionMail;
use App\Models\DemandeExplication;
use App\Models\MotifOutdate;
use App\Models\MotifSanction;
use App\Models\Notification;
use App\Models\PieceJointePropositionSanction;
use App\Models\PropositionSanction;
use App\Models\Sanction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Barryvdh\DomPDF\Facade\Pdf;

class SanctionController extends Controller
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
    public function test_generation_pdf(){
        Pdf::setOption(['dpi' => 50, 'defaultFont' => 'sans-serif'], true);

        $data = [
            'value one' => 'Valeur évènement hôte',
            'value two' => 'Valeur 2',
            'value three' => 'Valeur 3',
        ];

        $pdf = Pdf::loadView('sanctions.note_decision_sanction.avertissement', compact('data'));
        return $pdf->download('invoice.pdf');
    }

    public function history(){

        $users = User::whereHas('sanctions')->get();

        return view('sanctions.history', compact('users'));
    }

    public function history_add(Request $request){
        $request->validate([
            'user_id' => 'required',
            'motif_sanction_id' => 'required',
            'motif_outdate' => 'required',
            'motif_id' => 'required',
        ]);

        // dd($request->all());

        DB::beginTransaction();
            $motif_outdate = MotifOutdate::create([
                'motif_id' => $request->motif_id,
                'motif_outdate' => $request->motif_outdate,
            ]);

            Sanction::create([
                'decision' => $request->motif_sanction_id,
                'user_id' => $request->user_id,
                'demande_explication_id' => 1,
                'decideur' => 2,
                'motif_outdate_id' =>$motif_outdate->id,
            ]);

        DB::commit();

        alert()->success('Opération réussie','Sanction ajoutée avec succès');
        return back()->with('success','Sanction ajoutée avec succès');
    }
    // public function show(User $user){
    //     // dd($user);

    //     return view('sanctions.show');
    // }

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

    public function proposition(Request $request, User $user){
        // dump($user);

        $data = $request->validate([
            'proposition_sanction' => 'required',
            'demande_explication_id' => 'required',
            // 'user_id' => 'required',
        ],[
            'proposition_sanction.required' => 'La description de proposition de sanction est requise',
            'demande_explication_id.required' => 'Une erreur s\est produite. Veuillez reprendre',
            // 'user_id.required' => 'Une erreur s\est produite. Veuillez reprendre',
        ]);

        if($request->description){
            $data['description'] = nl2br($request->description);
        }

        DB::beginTransaction();
            // dd($request->all());
            $data['user_id'] = $user->id;

            $proposition_sanction = PropositionSanction::create($data);

            if($request->has('pieces_jointe')){
                $request->validate([
                    'pieces_jointe' => 'required',
                    'pieces_jointe.*' => 'mimes:jpeg,png,jpg,gif,svg',
                ],[
                    'pieces_jointe.*.required' => 'le choix d\'image est requis',
                    'pieces_jointe.*.image' => 'le fichier choisi doit être de type image',
                    'pieces_jointe.*.max' => 'la taille maximale du fichier choisi excède 2048 octects',
                    'pieces_jointe.*.mimes' => 'le fichier choisi doit être de type image(jpeg, png, jpg, gif, svg)',
                ]);
                // dd($request->pieces_jointe);

                foreach($request->pieces_jointe as $pieces_jointe){

                    $pieces_jointe = PieceJointePropositionSanction::create([
                        'piece_jointe' => $pieces_jointe->store('images','public'),
                        'proposition_sanction_id' => $proposition_sanction->id,
                    ]);

                    $pieces_jointe->uuid = $pieces_jointe->id . ':' . $pieces_jointe->uuid;
                    $pieces_jointe->save();

                    // dd($pieces_jointe);
                }
            }

            $demande_explication = DemandeExplication::find($request->demande_explication_id);

            $mailData = [
                'emetteur_fname' => $demande_explication->emetteur->fname,
                'emetteur_lname' => $demande_explication->emetteur->lname,
                'motif' => $demande_explication->motif->motif,
                'destinataire_fname' => $demande_explication->destinataires->fname,
                'destinataire_lname' => $demande_explication->destinataires->lname,
                'proposition_fname' => auth()->user()->fname,
                'proposition_lname' =>  auth()->user()->lname,
                'proposition_sanction' => $proposition_sanction->proposition->motif,
                'demande_explication_id' => $demande_explication->id,
                'numero_demande_explication' => $demande_explication->numero_demande_explication,
            ];

            $entity_id = $demande_explication->entity_id;
            $rh_users = User::whereHas('privileges', function($q) use($entity_id){
                $q->where([
                    'role_id' => 2,
                    'entity_id' => $entity_id
                ]);
            })->get();

            if($request->user_id != 0){
                $user = User::find($request->user_id);

                try{
                    $notification_exists = Notification::where([
                        'demande_explication_id' => $demande_explication->id,
                        'user_id' => $user->id,
                        'motif' => 'proposition_sanction',
                    ])->exists();
                    // dd($notification_exists);
                    if(!$notification_exists){
                        Notification::create([
                            'demande_explication_id' => $demande_explication->id,
                            'user_id' => $user->id,
                            'motif' => 'proposition_sanction',
                        ]);
                    }
                    $objet = 'Proposition de sanction';
                    $this->sendMailFunction($user->email, $mailData, $objet);

                    foreach($rh_users as $rh_user){
                        $this->sendMailFunction($rh_user->email, $mailData, $objet);
                    }

                }catch(\Exception $e){
                    alert()->error('Attention', 'Echec de notification par mail');
                    return back()->with('error', 'Echec de notification par mail');
                }
            }else{

                $user = User::whereHas('decision_sanction')->first();

                try{
                    Notification::create([
                        'demande_explication_id' => $demande_explication->id,
                        'user_id' => $user->id,
                        'motif' => 'invitation_decision_sanction',
                    ]);
                    $objet = 'Invitation - Décision de sanction';
                    $this->sendMailFunction($user->email, $mailData, $objet);

                    foreach($rh_users as $rh_user){
                        // Mail::to($rh_user->email)->send(new DecisionSanctionMail($mailData));
                        $this->sendMailFunction($rh_user->email, $mailData, $objet);
                    }
                }catch(\Exception $e){
                    alert()->error('Attention', 'Echec de notification par mail');
                    return back()->with('Attention', 'Echec de notification par mail');
                }
            }
        DB::commit();
        alert()->success('Opération réussie', 'Proposition de sanction effectuée avec succès');

        return back()->with('success', 'Proposition de sanction effectuée avec succès');
    }

    public function sendMailFunction($email, $mailData, $objet){
        Mail::to($email)->send(new PropositionSanctionMail($mailData, $objet));
    }

    public function decision(Request $request, User $user){
        // dump($request->all());
        // dd($user);

        $data = $request->validate([
            "demande_explication_id" => "required",
            "decision" => "required",
        ]);

        try{
            DB::beginTransaction();
                $demande = DemandeExplication::find($data['demande_explication_id']);
                $demande->status = true;
                $demande->save();

                $data['user_id'] = $demande->destinataire;
                $data['decideur'] = $user->id;

                if(Sanction::where($data)->exists()){
                    alert()->error('Attention', 'Décision de sanction déjà effectuée');
                    return back()->with('warning', 'Décision de sanction déjà effectuée');
                }

                if($request->description){
                    $data['description'] = nl2br($request->description);
                }

                $decision_sanction = Sanction::create($data);


                // DecisionSanctionJob::dispatch($demande, $decision_sanction);

                $notifications = Notification::where('demande_explication_id', $demande->id)
                                                ->where('user_id', '!=', $demande->destinataire)->get();

                $mailData = [
                    'emetteur_fname' => $demande->emetteur->fname,
                    'emetteur_lname' => $demande->emetteur->lname,
                    'motif' => $demande->motif->motif,
                    'destinataire_fname' => $demande->destinataires->fname,
                    'destinataire_lname' => $demande->destinataires->lname,
                    'decision' => $decision_sanction->decisions->motif,
                    'demande_explication_id' => $demande->id,
                    'numero_demande_explication' => $demande->numero_demande_explication,
                ];

                foreach($notifications as $notification){
                    Mail::to($notification->user->email)->send(new DecisionSanctionMail($mailData));
                }

                $entity_id = $demande->entity_id;
                $rh_users = User::whereHas('privileges', function($q) use($entity_id){
                    $q->where([
                        'role_id' => 2,
                        'entity_id' => $entity_id
                    ]);
                })->get();

                if($decision_sanction->decision == 1){
                    foreach($rh_users as $rh_user){
                        Mail::to($rh_user->email)->send(new DecisionSanctionMail($mailData, $rh_users));
                    }
                }else{
                    foreach($rh_users as $rh_user){
                        Mail::to($rh_user->email)->send(new DecisionSanctionRhMail($mailData, $rh_users));
                    }
                }
            DB::commit();

            alert()->success('Opération réussie', 'Décision de sanction effectuée avec succès');
            return back()->with('success', 'Décision de sanction effectuée avec succès');
        }catch(\Exception $e){
            // DB::rollBack();
            alert()->error('Erreur', 'Une erreur s\'est produite. Veuillez contacter votre administrateur');
            return back()->with('error', 'Une erreur s\'est produite. Veuillez contacter votre administrateur');
        }

    }

    public function decision_note(Request $request, User $user){

        // dd($request->all());
        $data = $request->validate([
            'note_decision_sanction' => 'required|mimes:pdf|max:4096',
            'demande_explication_id' => 'required'
        ],[
           'note_decision_sanction.max' => 'Le fichier importé ne doit pas depasser la taille de 4 Mo',
           'note_decision_sanction.mimes' => 'Le fichier importé ne doit qu\'être de type pdf',
        ]);

        try{
            $demande = DemandeExplication::find($data['demande_explication_id']);

            $rh_users = User::whereRelation('privileges', 'entity_id', '=', $demande->entity_id)->get();

            $mailData = [
                'destinataire' => $demande->destinataires,
                'initiateur' => $demande->emetteur,
                'demande' => $demande
            ];

            // dd($mailData);
            foreach($rh_users as $rh_user){
                Mail::to($rh_user->email)->send(new NoteDecisionSanctionMail($mailData));
            }
            Mail::to($demande->destinataires->email)->send(new NoteDecisionSanctionMail($mailData));

            $demande->update([
                'file_note_decision_sanction' => $request->note_decision_sanction->store('images','public'),
                'note_decision_sanction_submit_by' => auth()->user()->id,
            ]);
            alert()->success('Opération réussie', 'Importation du fichier réussie');
            return back();
        }catch(\Exception $e){
            alert()->error('Attention', 'Une erreur s\'est produite. Veuillez reprendre ou contacter votre administrateur');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user){

        // $demande = DemandeExplication::where('destinataire', $user->id)->orderBy('id', 'DESC')->get();
        return view('sanctions.show', compact('user'));
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
