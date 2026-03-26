<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class PanelEmpleadoController extends Controller
{
    public function index(): View
    {
        $pendingOrders = Order::query()->where('status', Order::STATUS_PENDING)->count();
        $deliveredOrders = Order::query()->where('status', Order::STATUS_DELIVERED)->count();
        $todayOrders = Order::query()->whereDate('created_at', now()->toDateString())->count();

        return view('employee.dashboard', [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'lowStockProducts' => Product::where('stock', '<', 10)->count(),
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'todayOrders' => $todayOrders,
            'latestPendingOrders' => Order::query()
                ->with('user')
                ->where('status', Order::STATUS_PENDING)
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}

