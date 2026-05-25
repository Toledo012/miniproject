<x-mail::message>
# Hola, {{ $nombre }}

Recibimos una solicitud de inicio de sesión en tu cuenta.

Tu código de verificación es:

<x-mail::panel>
**{{ $codigo }}**
</x-mail::panel>

Este código expira en **{{ $minutos }} minutos**. Si no fuiste tú, ignora este correo.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
