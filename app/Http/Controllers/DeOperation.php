<?php

namespace App\Http\Controllers;

use App\Mail\DemandeExplicationSendMail;
use App\Mail\InvitationReponseSupplementaireDeMail;
use App\Mail\ReponseDemandeExplicationMail;
use App\Mail\ReponseSupplementaireDeMail;
use App\Models\DemandeExplication;
use App\Models\Fonction;
use App\Models\Motif;
use App\Models\MotifSanction;
use App\Models\Notification;
use App\Models\PieceJointe;
use App\Models\PieceJointeReponse;
use App\Models\ReponseSupplementaireDe;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DeOperation extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $current_user_id = auth()->user()->grade_id;
        // $grade_id = ;
        // $entity_id = ;

        $fonction = Fonction::find(session('fonction_id')['fonction_id']);

        // A revoir car, on ne peut pas se donner soi-meme des DE
        $destinataires = User::whereRelation('user_entity', 'grade_id', '<=', $fonction->user_entity->grade_id)
                            ->whereRelation('user_entity', 'entity_id', '=', $fonction->user_entity->entity_id)
                            ->where('id', '!=', auth()->user()->id)->where('deleted',false)->get();

        $motifs = Motif::orderBy('motif', 'ASC')->get();

        return view('demandes_explication.create', compact('destinataires', 'motifs'));
    }

    public function de_transfered(){
        $current_user_id = auth()->user()->grade_id;
        // $grade_id = ;
        // $entity_id = ;

        $fonction = Fonction::find(session('fonction_id')['fonction_id']);

        // A revoir car, on ne peut pas se donner soi-meme des DE
        $destinataires = User::whereRelation('user_entity', 'grade_id', '<=', $fonction->user_entity->grade_id)
                            ->whereRelation('user_entity', 'entity_id', '=', $fonction->user_entity->entity_id)
                            ->where('id', '!=', auth()->user()->id)->where('deleted',false)->get();

        $motifs = Motif::orderBy('motif', 'ASC')->get();

        return view('demandes_explication.transfered', compact('destinataires', 'motifs'));
    }

    public function de_underproposal(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        $demandes = DemandeExplication::
        whereRelation('notifications', function($query) use($user_id){
            $query->where(['user_id' => $user_id, 'motif' => 'proposition_sanction']);
        })
        ->
        where([
            'status'=> false,
            'entity_id' => $current_entity_id
        ])
        ->doesntHave('proposition_sanctions')
        ->
        orderBy('id', 'DESC')->get();

        // dd($demandes);
        return view('demandes_explication.underproposal', compact('demandes'));
    }

    public function de_inprocess(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        $demandes = null;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::doesntHave('archive')->where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->orderBy('id', 'DESC')->get();
        }else{
            // dd(3);
            $demandes = DemandeExplication::where([
                    'status'=> false,
                    'destinataire'=>$user_id,
                    'entity_id' => $current_entity_id
                ])
                ->orWhere(function($query) use($user_id,$current_entity_id){
                    $query->where(['status'=> false,'initiateur'=>$user_id,'entity_id' => $current_entity_id]);
                })
                ->doesntHave('archive')->orderBy('id', 'DESC')->get();
        }

        return view('demandes_explication.inprocess', compact('demandes'));
    }
    public function de_underdecision(){

        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $demandes = null;
        if(auth()->user()->isAdmin() || auth()->user()->isRh() || auth()->user()->isDecideurSanction()){
            $demandes = DemandeExplication::whereRelation('notifications', function($query){
                $query->where(['motif' => 'invitation_decision_sanction']);
            })->where([
                'status'=> false,
                'entity_id' => $current_entity_id
            ])->doesntHave('sanction')->orderBy('id', 'DESC')->get();
        }
        else{
            return back();
        }

        return view('demandes_explication.underdecision', compact('demandes'));
    }
    public function de_undernote(){

        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $demandes = null;

        if(auth()->user()->isAdmin() || auth()->user()->isRh() || auth()->user()->isDecideurSanction()){
            $demandes = DemandeExplication::has('sanction')->where([
                'status'=> true,
                'entity_id' => $current_entity_id,
                'file_note_decision_sanction' => null
            ])->orderBy('id', 'DESC')->get();
        }
        else{
            return back();
        }
// dd($demandes);
        return view('demandes_explication.undernote', compact('demandes'));
    }

    public function de_notanswered(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->where('reponse', '=', null)->orderBy('id', 'DESC')->get();
        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->where('reponse', '=', null)->orderBy('id', 'DESC')->get();
        }

            $reponse_supplementaires = false;

        return view('demandes_explication.notanswered', compact('demandes', 'reponse_supplementaires'));
    }

    public function de_notanswered_ontime(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->whereNull('reponse')->orderBy('id', 'DESC')->get();
        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->whereNull('reponse')->orderBy('id', 'DESC')->get();
        }

            $reponse_supplementaires = false;

        return view('demandes_explication.notanswered_ontime', compact('demandes', 'reponse_supplementaires'));
    }
    public function de_notanswered_late(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->whereNull('reponse')->orderBy('id', 'DESC')->get();
        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->whereNull('reponse')->orderBy('id', 'DESC')->get();
        }

            $reponse_supplementaires = false;

        return view('demandes_explication.notanswered_late', compact('demandes', 'reponse_supplementaires'));
    }

    public function de_alreadyanswered(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $demandes = null;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->where('reponse', '!=', null)->orderBy('id', 'DESC')->get();
        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->where('reponse', '!=', null)->orderBy('id', 'DESC')->get();
        }

        $reponse_supplementaires = false;

        return view('demandes_explication.alreadyanswered', compact('demandes', 'reponse_supplementaires'));
    }

    public function de_alreadyanswered_ontime(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $demandes = null;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where(function($query) use($demandes){
                // $query->
            })->where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();
                // ])->whereTime(['date_reponse' - 'created_at' , '<=' , 259200])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();


        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();
        }

        $reponse_supplementaires = false;
        $state_of_demand = "ontime";

        return view('demandes_explication.alreadyanswered_ontime', compact('demandes', 'reponse_supplementaires','state_of_demand'));
    }

    function de_alreadyanswered_late(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;
        $demandes = null;

        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where(function($query) use($demandes){
                // $query->
            })->where([
                'status'=> false,
                'entity_id' => $current_entity_id
                ])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();
                // ])->whereTime(['date_reponse' - 'created_at' , '<=' , 259200])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();


        }else{
            $demandes = DemandeExplication::where([
                'status'=> false,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->whereNotNull('reponse')->orderBy('id', 'DESC')->get();
        }

        $reponse_supplementaires = false;
        $state_of_demand = "ontime";

        return view('demandes_explication.alreadyanswered_late', compact('demandes', 'reponse_supplementaires','state_of_demand'));
    }

    public function de_repondre_supplementaire(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        $demandes = DemandeExplication::whereHas('reponse_supplementaires', function($query) use ($user_id){
            $query->where([
               'user_id'=> $user_id,
               'reponse' => null]);
        })->where([
            'status'=> false,
            'entity_id' => $current_entity_id
            ])->orderBy('id', 'DESC')->get();

            // dump($demandes);
            // dd($user_id);
        $reponse_supplementaires = true;

        return view('demandes_explication.alreadyanswered', compact('demandes', 'reponse_supplementaires'));
    }

    public function de_archived(){
        $user_id = auth()->user()->id;
        $current_entity_id = auth()->user()->current_user_entity()->entity_id;

        $demandes = null;
        if(auth()->user()->isAdmin() || auth()->user()->isRh()){
            $demandes = DemandeExplication::where([
                'status'=> true,
                'entity_id' => $current_entity_id
                ])->orderBy('id', 'DESC')->get();
        }else{
            $demandes = DemandeExplication::where([
                'status'=> true,
                'destinataire'=>$user_id,
                'entity_id' => $current_entity_id
                ])->orWhere(function($query) use ($user_id, $current_entity_id) {
                    $query->where([
                        'status'=> true,
                        'initiateur'=>$user_id,
                        'entity_id' => $current_entity_id
                        ]);
                })->orderBy('id', 'DESC')->get();
        }
        return view('demandes_explication.archived', compact('demandes'));
    }

    public function de_answered(Request $request, $demande){

        $data = $request->validate([
            'reponse'=>'required|string',
        ],[
            'reponse.required' => "Le champ de reponse est requis",
            'reponse.string' => "Le champ de reponse doit etre un texte",
        ]);

        $data['reponse'] = nl2br($data['reponse']);
        try{
            DB::beginTransaction();
            $reponse_demande = DemandeExplication::find($demande);

            if($reponse_demande->destinataire != auth()->user()->id){
                alert()->error('Attention', 'Une erreur s\'est produite');
                return back()->with('error', 'Une erreur s\'est produite');
            }

            if($reponse_demande->reponse){
                alert()->error('Attention', 'Vous avez déjà répondu à cette demande d\'explication');
                return back()->with('error', 'Vous avez déjà répondu à cette demande d\'explication');
            }else{
                $reponse_demande->reponse = $request->reponse;
                $reponse_demande->date_reponse = date('Y-m-d H:i:s');

                $reponse_demande->save();

                // dd($request->pieces_jointe);
                if($request->has('pieces_jointe')){

                    $request->validate([
                        'pieces_jointe.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    ],[
                        'pieces_jointe.required' => 'le choix d\'image est requis',
                        'pieces_jointe.image' => 'le fichier choisi doit etre de type image',
                        'pieces_jointe.max' => 'la taille maximale du fichier choisi est 2048 octects',
                        'pieces_jointe.mimes' => 'le fichier choisi doit etre de type image(jpeg, png, jpg, gif, svg)',
                    ]);

                    foreach($request->pieces_jointe as $pieces_jointe){
                        // $fileName = time().'.'.$pieces_jointe->extension();
                        // $pieces_jointe->move(public_path('images'), $fileName);

                        $pieces_jointe = PieceJointeReponse::create([
                            'piece_jointe' => $pieces_jointe->store('images','public'),
                            'demande_explication_id' => $reponse_demande->id,
                        ]);
                    }
                }

                $fonction = Fonction::find(session('fonction_id')['fonction_id']);
                $mailData = [
                    'emetteur_fname' => $reponse_demande->emetteur->fname,
                    'emetteur_lname' => $reponse_demande->emetteur->lname,
                    // 'emetteur_fonction' => $fonction->fonction,
                    // 'emetteur_grade' => $fonction->user_entity->grade->title,
                    'motif' => $reponse_demande->motif->motif,
                    'destinataire_fname' => auth()->user()->fname,
                    'destinataire_lname' => auth()->user()->lname,
                    'demande_explication_id' => $reponse_demande->id,
                    'numero_demande_explication' => $reponse_demande->numero_demande_explication,
                ];

                $notification = Notification::where(['demande_explication_id' => $reponse_demande->id, 'user_id' => $reponse_demande->initiateur])->first();
                $notification->motif = 'proposition_sanction';
                $notification->update();

                Mail::to($reponse_demande->emetteur->email)->send(new ReponseDemandeExplicationMail($mailData));
                Mail::to(auth()->user()->email)->send(new ReponseDemandeExplicationMail($mailData));

                $entity_id = $reponse_demande->entity_id;
                $rh_users = User::whereHas('privileges', function($q) use($entity_id){
                    $q->where([
                        'role_id' => 2,
                        'entity_id' => $entity_id
                    ]);
                })->get();

                foreach($rh_users as $rh_user){
                    Mail::to($rh_user->email)->send(new ReponseDemandeExplicationMail($mailData));
                }

                DB::commit();
                alert()->success('Succès', 'Demande répondue avec success');

                return back()->with('success', 'Demande répondue avec success');
            }
        }catch(\Exception $e){
            alert()->error('Attention', 'Une erreur s\'est produite. Veuillez vérifier le type de fichiers importés ou contacter votre administrateur');
            return back()->with('error', 'Une erreur s\'est produite');
        }

    }
    public function de_answered_supplementaire(Request $request, $demande){
        $data = $request->validate([
            'description'=>'required|string',
            'user_id'=>'required',
        ],[
            'description.required' => "Le champ de reponse est requis",
            'description.string' => "Le champ de reponse doit etre un texte",
            'user_id.required' => "Le destinataire est requis",
        ]);

        // dd($demande->destinataire);

        try{
            $demande = DemandeExplication::find($demande);
            $data['description'] = nl2br($data['description']);
            // $data['user_id'] = $demande->destinataire;
            $data['demande_explication_id'] = $demande->id;
            $data['initiateur'] = auth()->user()->id;
            DB::beginTransaction();
            ReponseSupplementaireDe::create($data);

            $destinataire = User::findOrfail($data['user_id']);

            $mailData = [
                'numero_demande_explication' => $demande->numero_demande_explication,
                'emetteur_fname' => auth()->user()->fname,
                'emetteur_lname' => auth()->user()->lname,
                'motif' => $demande->motif->motif,
                'demande' => $demande,
                'destinataire_fname' => $destinataire->fname,
                'destinataire_lname' => $destinataire->lname,
                'demande_explication_id' => $demande->id,
            ];
            Mail::to($destinataire->email)->send(new InvitationReponseSupplementaireDeMail($mailData));
            Mail::to(auth()->user()->email)->send(new InvitationReponseSupplementaireDeMail($mailData));

            $entity_id = $demande->entity_id;
            $rh_users = User::whereHas('privileges', function($q) use($entity_id){
                $q->where([
                    'role_id' => 2,
                    'entity_id' => $entity_id
                ]);
            })->get();

            foreach($rh_users as $rh_user){
                Mail::to($rh_user->email)->send(new InvitationReponseSupplementaireDeMail($mailData));
            }

            DB::commit();
            alert()->success('Succès', 'Invitation envoyée avec success');

            return back()->with('success', 'Invitation envoyée avec success');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Une erreur s\'est produite. Bien vouloir reprendre ou contacter votre administrateur');
        }
    }
    public function de_form_reponse_supplementaire(Request $request, $reponse_supplementaire){
        $data = $request->validate([
            'reponse' => 'required',
        ],[
            'reponse.required' => 'Ce champs est requis',
        ]);

        $data['reponse'] = nl2br($data['reponse']);
        try{
            DB::beginTransaction();
                $reponse_supplementaire = ReponseSupplementaireDe::find($reponse_supplementaire);
                $data['date_reponse'] = now();

                // dd($reponse_supplementaire);
                $reponse_supplementaire->update($data);

                $destinataire = $reponse_supplementaire->user;
                $initiateur = $reponse_supplementaire->initiateurs;

                // dd($reponse_supplementaire->demandes);

                $mailData = [
                    'numero_demande_explication' => $reponse_supplementaire->demandes->numero_demande_explication,
                    'emetteur_fname' => $initiateur->fname,
                    'emetteur_lname' => $initiateur->lname,
                    'motif' => $reponse_supplementaire->demandes->motif->motif,
                    'demande' => $reponse_supplementaire->demandes,
                    'destinataire_fname' => $destinataire->fname,
                    'destinataire_lname' => $destinataire->lname,
                    'demande_explication_id' => $reponse_supplementaire->demande_explication_id,
                ];
                // dd($mailData);
                Mail::to($destinataire->email)->send(new ReponseSupplementaireDeMail($mailData));
                Mail::to($initiateur->email)->send(new ReponseSupplementaireDeMail($mailData));

            DB::commit();
            alert()->success('Opération réussie', 'Réponse envoyée avec succès');
            return back()->with('success', 'Réponse envoyée avec succès');
        }catch(\Exception $e){
            DB::rollBack();

            alert()->error('Attention', 'Une erreur s\'est produite. Veuillez reprendre ou contacter votre administrateur');
            return back()->with('error', 'Une erreur s\'est produite. Veuillez reprendre ou contacter votre administrateur');
        }
    }
    public function de_history_export(Request $request, User $user){
        if($request->date_debut && $request->date_fin){
            $request->validate([
                'date_fin' => 'after_or_equal:date_debut'
            ],[
               'date_fin.after_or_equal' => 'La date de fin doit être inférieure à la date de début',
            ]);
        }

        $demande_explications = DemandeExplication::where([
            'destinataire' => $user->id
        ])->get();

        if($request->date_debut){
            $demande_explications = DemandeExplication::where([
                'destinataire' => $user->id
            ])->where(
                'created_at', '>=', $request->date_debut
            )->get();
        }
        if($request->date_fin){
            $demande_explications = DemandeExplication::where([
                'destinataire' => $user->id
            ])->where(
                'created_at', '<=', $request->date_fin
            )->get();
        }

        if($request->date_debut && $request->date_fin){
            $demande_explications = DemandeExplication::where([
                'destinataire' => $user->id
            ])->whereBetween(
                'created_at', [$request->date_debut, $request->date_fin]
            )->get();
        }

        // dump($user->id);
        // dump($request->all());
        // dd($demande_explications);
        // Nom et prenom
        // Motif de la demande
        // date de la DE
        // initie par
        // reponse
        // date de reponse
        // sanction
        // date de decision de sanction

        $line[] = [];
        $k = 0;
        foreach($demande_explications as $demande_explication){
            $line[$k]['N°'] = $k + 1;
            $line[$k]['Nom et prenom'] = $demande_explication->destinataires->fname . ' ' . $demande_explication->destinataires->lname;
            $line[$k]['N° de DE'] = $demande_explication->numero_demande_explication;
            $line[$k]['Initiateur'] = $demande_explication->emetteur->fname . ' ' . $demande_explication->emetteur->lname;
            $line[$k]['Motif'] = $demande_explication->motif->motif;
            $line[$k]['Date de la DE'] = $demande_explication->created_at;
            $line[$k]['Description de la DE'] = preg_replace('#<br\s*/?>#i', "\n", $demande_explication->description);

            if($demande_explication->reponse){
                $line[$k]['Réponse'] = preg_replace('#<br\s*/?>#i', "\n", $demande_explication->reponse);
                $line[$k]['Date de réponse'] = $demande_explication->date_reponse;
            }else{
                $line[$k]['Statut de réponse'] = 'Non répondu';
                $line[$k]['Date de réponse'] = '-';
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

        $writer = SimpleExcelWriter::streamDownload($user->fname . '-' . $user->lname .'_export_history_demand_'. $date .'.xlsx')
        ->addRows($line);

    }

    /**
     * function to generate explanation demand number
     *
     * @param [type] $demande_explication_id
     * @return void
     */
    public function numero_demande_explication($demande_explication_id){
        $date = Str::Substr(date('Y'), -2);

        $length = Str::length($demande_explication_id);
        $zeros = '';

        for($k = 1; $k <= (6 - $length); $k++){
            $zeros .= '0';
        }
        return $zeros . $demande_explication_id . '/' . $date;
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // $rh_users = User::whereHas('privileges', function($q){
        //     $q->where('role_id', 2);
        // })->get();

        // dd($rh_users);
        $data = $request->validate([
            'destinataire.*'=>'required|integer',
            'motif_id'=>'required|integer',
            'description'=>'required|string',
        ],[
            'destinataire.*.required' => "Veuillez choisir un destinataire",
            'destinataire.*.integer' => "Veuillez choisir un destinataire",
            'motif_id.required' => "Veuillez choisir un motif",
            'motif_id.integer' => "Veuillez choisir un motif",
            'description.required' => "Veuillez remplir la description",
            'description.string' => "La description doit etre un texte",
        ]);
        $data['description'] = nl2br($data['description']);
        // $data['entity_id'] = Fonction::find(session('fonction_id')['fonction_id'])->user_entity->entity_id;

        // if($request->entity_id){
        //     $data['entity_id'] = $request->entity_id;
        // }

        $data['initiateur'] = auth()->user()->id;
        $data['entity_id'] = auth()->user()->current_user_entity()->entity_id;

        // dd($data);
        DB::beginTransaction();
        // dd(count($data['destinataire']));
        $demande_explication = null;

        foreach($data['destinataire'] as $destinataire){
            $data['destinataire'] = $destinataire;
            $demande_explication = DemandeExplication::create($data);

            $demande_explication->update([
                'numero_demande_explication' => $this->numero_demande_explication($demande_explication->id),
            ]);


            if($request->has('pieces_jointe')){
                $request->validate([
                    'pieces_jointe.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ],[
                    'pieces_jointe.*.required' => 'le choix d\'image est requis',
                    'pieces_jointe.*.image' => 'le fichier choisi doit être de type image',
                    'pieces_jointe.*.max' => 'la taille maximale du fichier choisi excède 2048 octects',
                    'pieces_jointe.*.mimes' => 'le fichier choisi doit être de type image(jpeg, png, jpg, gif, svg)',
                ]);

                foreach($request->pieces_jointe as $pieces_jointe){

                    $pieces_jointe = PieceJointe::create([
                        'piece_jointe' => $pieces_jointe->store('images','public'),
                        'demande_explication_id' => $demande_explication->id,
                    ]);
                }
            }

            Notification::create([
                'demande_explication_id' => $demande_explication->id,
                'user_id' => $data['initiateur'],
                'motif' => 'demande_explication',
            ]);

            Notification::create([
                'demande_explication_id' => $demande_explication->id,
                'user_id' => $demande_explication->destinataire,
                'motif' => 'demande_explication',
            ]);


            $fonction = Fonction::find(session('fonction_id')['fonction_id']);
            $mailData = [
                'emetteur_fname' => auth()->user()->fname,
                'emetteur_lname' => auth()->user()->lname,
                'emetteur_fonction' => $fonction->fonction,
                'emetteur_grade' => $fonction->user_entity->grade->title,
                'motif' => $demande_explication->motif->motif,
                'destinataire_fname' => $demande_explication->destinataires->fname,
                'destinataire_lname' => $demande_explication->destinataires->lname,
                'description' => $demande_explication->description,
                'demande_explication_id' => $demande_explication->id,
                'numero_demande_explication' => $demande_explication->numero_demande_explication,
            ];


            // Notifications de ceux qui sont en copie et initiateur et destinataire
            $notifications = Notification::where([
                'demande_explication_id' => $demande_explication->id
            ])->get();

            foreach($notifications as $notification){
                $this->sendMailFunction($notification->user->email, $mailData);
            }

            // send RH email
            $this->send_rh_mail($mailData, $data['entity_id']);
        }


        DB::commit();

        // dump(2);
        alert()->success('Succès', 'Demande d\'explication envoyée avec succès');
        // de.show'
        return redirect()->route('de.show', $demande_explication->id)->with('succes', 'Demande d\'explication envoyée avec succès');
    }
    public function send_rh_mail($mailData, $entity_id){
        $rh_users = User::whereHas('privileges', function($q) use($entity_id){
            $q->where([
                'role_id' => 2,
                'entity_id' => $entity_id
            ]);
        })->get();

        foreach($rh_users as $rh_user){
            $this->sendMailFunction($rh_user->email, $mailData);
        }
    }
    public function sendMailFunction($email, $mailData){
        Mail::to($email)->send(new DemandeExplicationSendMail($mailData));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DemandeExplication $demande){
        $check_abilities_showing_de = $demande->whereRelation('notifications', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        })->exists();

        $mustProvideMoreInformation =ReponseSupplementaireDe::where('user_id', auth()->user()->id)->exists();

        // dd($mustProvideMoreInformation);
        // dd(auth()->user()->current_user_entity()->id == $demande->entity_id);
        if($check_abilities_showing_de || $mustProvideMoreInformation || (auth()->user()->current_user_entity()->id == $demande->entity_id) || auth()->user()->isRh()){

            $fonction = Fonction::find(session('fonction_id')['fonction_id']);

            $hierarchic_superiors = User::whereHas('user_entity', function($query) use($fonction){
                $query->where('grade_id', '>=', $fonction->user_entity->grade_id);
            })->doesntHave('decision_sanction')->where('id', '!=', auth()->user()->id)->get();

            $users = User::whereHas('user_entity', function($query) use($fonction){
                $query->where('grade_id','<=', $fonction->user_entity->grade_id);
            })->where('id','!=',auth()->user()->id)->where('id','!=',$demande->destinataire)->get();

            $motif_sanctions = MotifSanction::get();
            return view('demandes_explication.show', compact('demande', 'motif_sanctions', 'hierarchic_superiors', 'users'));
        }else{
            return back();
        }
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
