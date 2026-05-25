<?php

namespace App\Services;

use App\Mail\VentaRechazadaComprador;
use App\Mail\VentaValidadaComprador;
use App\Mail\VentaValidadaVendedor;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VentaService
{
    private const DISCO_TICKETS = 'private';

    public function crear(User $comprador, Producto $producto, int $cantidad, UploadedFile $ticket): Venta
    {
        if ($cantidad > $producto->stock) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad solicitada supera el stock disponible.',
            ]);
        }

        if ($producto->vendedor_id === $comprador->id) {
            throw ValidationException::withMessages([
                'producto_id' => 'No puedes comprar un producto publicado por ti.',
            ]);
        }

        return DB::transaction(function () use ($comprador, $producto, $cantidad, $ticket) {
            $venta = Venta::create([
                'comprador_id' => $comprador->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'total' => round((float) $producto->precio * $cantidad, 2),
                'estado' => 'pendiente',
            ]);

            $ruta = $ticket->store("tickets/{$venta->id}", self::DISCO_TICKETS);
            $venta->update(['ticket_ruta' => $ruta]);

            return $venta;
        });
    }

    public function validar(Venta $venta, User $gerente): Venta
    {
        if ($venta->estado !== 'pendiente') {
            throw ValidationException::withMessages([
                'estado' => 'Solo se pueden validar ventas pendientes.',
            ]);
        }

        $ventaActualizada = DB::transaction(function () use ($venta, $gerente) {
            $producto = $venta->producto()->lockForUpdate()->first();

            if ($venta->cantidad > $producto->stock) {
                throw ValidationException::withMessages([
                    'cantidad' => 'Stock insuficiente para validar esta venta.',
                ]);
            }

            $producto->decrement('stock', $venta->cantidad);

            $venta->update([
                'estado' => 'validada',
                'validado_por' => $gerente->id,
            ]);

            return $venta->fresh(['producto.vendedor', 'comprador']);
        });

        Mail::to($ventaActualizada->comprador->email)->send(new VentaValidadaComprador($ventaActualizada));
        Mail::to($ventaActualizada->producto->vendedor->email)->send(new VentaValidadaVendedor($ventaActualizada));

        return $ventaActualizada;
    }

    public function rechazar(Venta $venta, User $gerente): Venta
    {
        if ($venta->estado !== 'pendiente') {
            throw ValidationException::withMessages([
                'estado' => 'Solo se pueden rechazar ventas pendientes.',
            ]);
        }

        $venta->update([
            'estado' => 'rechazada',
            'validado_por' => $gerente->id,
        ]);

        $ventaActualizada = $venta->fresh(['producto', 'comprador']);

        Mail::to($ventaActualizada->comprador->email)->send(new VentaRechazadaComprador($ventaActualizada));

        return $ventaActualizada;
    }

    public function eliminarTicketSiExiste(Venta $venta): void
    {
        if ($venta->ticket_ruta && Storage::disk(self::DISCO_TICKETS)->exists($venta->ticket_ruta)) {
            Storage::disk(self::DISCO_TICKETS)->delete($venta->ticket_ruta);
        }
    }
}
