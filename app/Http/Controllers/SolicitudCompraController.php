<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolicitudCompraController extends Controller
{
    public function index(Request $request): View
    {
        $estatuses = [
            Order::STATUS_PENDING => 'Pendiente',
            Order::STATUS_DELIVERED => 'Entregado',
            Order::STATUS_CANCELLED => 'Cancelado',
        ];

        $filtroEstatus = $request->string('status')->toString();
        $filtroValido = $filtroEstatus === '' || array_key_exists($filtroEstatus, $estatuses);

        $pedidos = Order::query()
            ->with(['user', 'items'])
            ->when($filtroValido && $filtroEstatus !== '', function ($consulta) use ($filtroEstatus) {
                $consulta->where('status', $filtroEstatus);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('employee.purchase-requests.index', [
            'orders' => $pedidos,
            'statuses' => $estatuses,
            'selectedStatus' => $filtroValido ? $filtroEstatus : '',
        ]);
    }

    public function actualizarEstado(Request $request, Order $order): RedirectResponse
    {
        $datosValidados = $request->validate([
            'status' => ['required', 'in:'.implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED,
            ])],
            'status_filter' => ['nullable', 'in:'.implode(',', [
                '',
                Order::STATUS_PENDING,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED,
            ])],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $order->status = $datosValidados['status'];
        $order->saveOrFail();

        $consulta = [];
        if (! empty($datosValidados['status_filter'])) {
            $consulta['status'] = $datosValidados['status_filter'];
        }
        if (! empty($datosValidados['page'])) {
            $consulta['page'] = $datosValidados['page'];
        }

        return redirect()->route('employee.purchase-requests.index', $consulta)
            ->with('status', 'Estado de pedido actualizado.');
    }
}

