<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VentaValidadaComprador extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu compra ha sido validada',
        );
    }

    public function content(): Content
    {
        $this->venta->loadMissing(['producto.vendedor', 'comprador']);

        return new Content(
            markdown: 'emails.venta-validada-comprador',
            with: [
                'comprador' => $this->venta->comprador->nombre,
                'producto' => $this->venta->producto->nombre,
                'cantidad' => $this->venta->cantidad,
                'total' => $this->venta->total,
                'ventaId' => $this->venta->id,
                'vendedorNombre' => $this->venta->producto->vendedor->nombre,
                'vendedorEmail' => $this->venta->producto->vendedor->email,
            ],
        );
    }
}
