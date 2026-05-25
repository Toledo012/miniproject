<x-mail::message>
# ¡Hola, {{ $comprador }}!

Tu compra **#{{ $ventaId }}** ha sido **validada** correctamente.

**Detalle del pedido**
- Producto: {{ $producto }}
- Cantidad: {{ $cantidad }}
- Total: ${{ number_format((float) $total, 2) }}

## Contacta al vendedor

Para coordinar la entrega de tu pedido, comunícate directamente con el vendedor:

- **Vendedor:** {{ $vendedorNombre }}
- **Correo:** {{ $vendedorEmail }}

Por favor escríbele incluyendo el número de pedido **#{{ $ventaId }}** para que pueda identificar tu compra.

Gracias por tu compra,<br>
{{ config('app.name') }}
</x-mail::message>
