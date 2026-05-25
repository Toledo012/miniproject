<x-mail::message>
# Hola, {{ $comprador }}

Lamentamos informarte que tu compra **#{{ $ventaId }}** fue **rechazada**.

**Detalle**
- Producto: {{ $producto }}
- Cantidad: {{ $cantidad }}

El motivo puede deberse a comprobante no válido, datos incompletos o stock no disponible. Si crees que se trata de un error, comunícate con nuestro equipo de soporte.

Atentamente,<br>
{{ config('app.name') }}
</x-mail::message>
