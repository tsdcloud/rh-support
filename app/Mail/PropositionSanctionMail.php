<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropositionSanctionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $objet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $objet)
    {
        $this->mailData = $mailData;
        $this->objet = $objet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->objet)->view('demandes_explication.proposition_sanction_mail');
        
    }
}
