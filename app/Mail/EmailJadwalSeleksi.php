<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\email_template;
use App\Models\PendaftaranMagang;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailJadwalSeleksi extends Mailable
{
    use Queueable, SerializesModels;
    
    public $namamhs;
    public $label_step;
    public $namaindustri;
    public $intern_position;

    /**
     * Create a new message instance.
     * 
     * @return void
     */
    public function __construct(PendaftaranMagang $pendaftar) {
        $this->namamhs = $pendaftar->namamhs;
        $this->label_step = $pendaftar->label_step;
        $this->namaindustri = $pendaftar->namaindustri;
        $this->intern_position = $pendaftar->intern_position;
    }

    public function build()
    {
        return $this
            ->subject('Lolos Seleksi')
            ->markdown('email.jadwal_seleksi')->withSymfonyMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Track', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Clicks', 'no');
            $headers->addTextHeader('X-Mailgun-Track-Opens', 'no');
        });
    }
}
