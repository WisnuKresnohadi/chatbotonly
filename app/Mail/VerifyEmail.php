<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    public $subject;
    public $name;
    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->url = $data['url'];
        $this->subject = 'Notifikasi';
        $this->name = $data['name'];
        $this->message = $data['message'];
    }

    public function build()
    {
        return $this->subject($this->subject)->markdown('email.verify') ->withSymfonyMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Track', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Clicks', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Opens', 'no');
        });
    }
}
