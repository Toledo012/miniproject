<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        $compradores = User::where('rol', 'comprador')->get();
        $gerente = User::where('rol', 'gerente')->first();
        $productos = Producto::all();

        if ($compradores->isEmpty() || $productos->isEmpty()) {
            return;
        }

        $disco = Storage::disk('private');
        $estados = ['pendiente', 'validada', 'rechazada'];

        for ($i = 0; $i < 40; $i++) {
            $comprador = $compradores->random();
            $producto = $productos->random();
            $cantidad = random_int(1, 3);
            $estado = $estados[array_rand($estados)];

            $venta = Venta::create([
                'comprador_id' => $comprador->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'total' => round((float) $producto->precio * $cantidad, 2),
                'ticket_ruta' => null,
                'estado' => $estado,
                'validado_por' => $estado === 'pendiente' ? null : $gerente?->id,
            ]);

            $ruta = "tickets/{$venta->id}/".Str::random(40).'.txt';
            $disco->put(
                $ruta,
                "Ticket de venta #{$venta->id}\nComprador: {$comprador->nombre}\nProducto: {$producto->nombre}\nCantidad: {$cantidad}\nTotal: {$venta->total}\n"
            );
            $venta->update(['ticket_ruta' => $ruta]);
        }
    }
}
