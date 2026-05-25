<x-mail::message>
# ¡Hola, {{ $vendedor }}!

Una venta de tu producto ha sido **validada** por el equipo. Procede con la preparación y contacto con el comprador.

**Detalle de la venta #{{ $ventaId }}**
- Producto vendido: {{ $producto }}
- Cantidad: {{ $cantidad }}
- Total: ${{ number_format((float) $total, 2) }}

## Datos del comprador

- **Nombre:** {{ $compradorNombre }}
- **Correo:** {{ $compradorEmail }}

Por favor contáctalo a la brevedad para coordinar la entrega.

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
