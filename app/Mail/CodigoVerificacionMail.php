<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $usuario,
        public string $codigo,
        public int $minutosVigencia = 5,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu código de verificación',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.codigo-verificacion',
            with: [
                'nombre' => $this->usuario->nombre,
                'codigo' => $this->codigo,
                'minutos' => $this->minutosVigencia,
            ],
        );
    }
}
