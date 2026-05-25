<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VentaValidadaVendedor extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Una venta de tu producto ha sido validada',
        );
    }

    public function content(): Content
    {
        $this->venta->loadMissing(['producto.vendedor', 'comprador']);

        return new Content(
            markdown: 'emails.venta-validada-vendedor',
            with: [
                'vendedor' => $this->venta->producto->vendedor->nombre,
                'producto' => $this->venta->producto->nombre,
                'cantidad' => $this->venta->cantidad,
                'total' => $this->venta->total,
                'ventaId' => $this->venta->id,
                'compradorNombre' => $this->venta->comprador->nombre,
                'compradorEmail' => $this->venta->comprador->email,
            ],
        );
    }
}
