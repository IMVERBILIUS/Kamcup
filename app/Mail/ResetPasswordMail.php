<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        return $this->subject('Reset Password')
                    ->view('auth.passwords.email');
    }
}
