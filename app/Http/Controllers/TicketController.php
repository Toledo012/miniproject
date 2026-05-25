<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketController extends Controller
{
    public function show(Venta $venta): StreamedResponse|Response
    {
        $this->authorize('verTicket', $venta);

        if (! $venta->ticket_ruta || ! Storage::disk('private')->exists($venta->ticket_ruta)) {
            abort(404);
        }

        return Storage::disk('private')->download($venta->ticket_ruta);
    }
}
