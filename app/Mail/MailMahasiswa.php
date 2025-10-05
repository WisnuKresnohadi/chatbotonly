<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailMahasiswa extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $dataMhs;

    public function __construct($dataMhs) {
        $this->subject = 'Kandidat Magang Baru';
        $this->dataMhs = $dataMhs;
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->markdown('email.screening_mhs') ->withSymfonyMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Track', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Clicks', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Opens', 'no');
        });
    }
}
