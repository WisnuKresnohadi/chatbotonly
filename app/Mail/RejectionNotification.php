<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $name;
    public $reason;

    public function __construct($data) {
        $this->subject = 'Registrasi Ditolak!';
        $this->name = $data['name'];
        $this->reason = $data['reason'];
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->markdown('email.rejected');         
    }
}
