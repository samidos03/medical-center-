<?php
namespace App\Mail;
use App\Models\Rendezvous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelRdv extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rendezvous $rendezvous) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel - Votre rendez-vous demain - Bahjawa Medical Center',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rdv.rappel',
            with: [
                'rendezvous' => $this->rendezvous,
                'patient'    => $this->rendezvous->patient->user,
                'medecin'    => $this->rendezvous->medecin->user,
                'date'       => \Carbon\Carbon::parse($this->rendezvous->date_rdv)->format('d/m/Y'),
                'heure'      => substr($this->rendezvous->heure_rdv, 0, 5),
            ]
        );
    }
}
