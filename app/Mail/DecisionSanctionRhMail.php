<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecisionSanctionRhMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    public $rh_users;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $rh_users)
    {
        $this->mailData = $mailData;
        $this->rh_users = $rh_users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation à rédiger une note de décision de sanction')->view('demandes_explication.decision_sanction_rh_mail');
    }
}
