<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VentaRechazadaComprador extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu compra fue rechazada',
        );
    }

    public function content(): Content
    {
        $this->venta->loadMissing(['producto', 'comprador']);

        return new Content(
            markdown: 'emails.venta-rechazada',
            with: [
                'comprador' => $this->venta->comprador->nombre,
                'producto' => $this->venta->producto->nombre,
                'cantidad' => $this->venta->cantidad,
                'ventaId' => $this->venta->id,
            ],
        );
    }
}
