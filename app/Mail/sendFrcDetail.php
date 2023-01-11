<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendFrcDetail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        if ($user->frc_pdf != NULL) {
            $this->frc_pdf = public_path($user->frc_pdf);
        }else{
            $this->frc_pdf = NULL;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->frc_pdf != NULL){
            return $this->view('frcemailview')
            ->attach($this->frc_pdf);
        }else{
            return $this->view('frcemailview');
        }
    
    }
}
