<?php

namespace App\Jobs;

use App\Mail\DecisionSanctionMail;
use App\Mail\DecisionSanctionRhMail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DecisionSanctionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $demande;
    public $decision_sanction;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($demande, $decision_sanction)
    {
        $this->demande = $demande;
        $this->decision_sanction = $decision_sanction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notifications = Notification::where('demande_explication_id', $this->demande->id)
                                                ->where('user_id', '!=', $this->demande->destinataire)->get();
        $demande = $this->demande;
                $mailData = [
                    'emetteur_fname' => $demande->emetteur->fname,
                    'emetteur_lname' => $demande->emetteur->lname,
                    'motif' => $demande->motif->motif,
                    'destinataire_fname' => $demande->destinataires->fname,
                    'destinataire_lname' => $demande->destinataires->lname,
                    'decision' => $this->decision_sanction->decisions->motif,
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

                if($this->decision_sanction->decision == 1){
                    foreach($rh_users as $rh_user){
                        Mail::to($rh_user->email)->send(new DecisionSanctionMail($mailData, $rh_users));
                    }
                }else{
                    foreach($rh_users as $rh_user){
                        Mail::to($rh_user->email)->send(new DecisionSanctionRhMail($mailData, $rh_users));
                    }
                }
    }
}
