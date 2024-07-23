<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $url;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Email Verification')
                    ->view('emails.verify-email')
                    ->with([
                        'name' => $this->name,
                        'url' => $this->url,
                    ]);
    }
}
