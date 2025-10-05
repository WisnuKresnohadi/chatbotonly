<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContainer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $subject, 
        public $name, 
        public $company, 
        public $content
    ){}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->markdown('email.general')->withSymfonyMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Track', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Clicks', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Opens', 'no');
        });
    }

}
