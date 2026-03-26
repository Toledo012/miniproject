<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class PanelGerenteController extends Controller
{
    public function index(): View
    {
        $pendingOrders = Order::query()->where('status', Order::STATUS_PENDING)->count();
        $deliveredOrders = Order::query()->where('status', Order::STATUS_DELIVERED)->count();
        $todaySales = (float) Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');

        return view('manager.dashboard', [
            'totalUsers' => User::count(),
            'totalEmployees' => User::where('role', User::ROLE_EMPLEADO)->count(),
            'totalClients' => User::where('role', User::ROLE_CLIENTE)->count(),
            'totalProducts' => Product::count(),
            'lowStockProducts' => Product::query()->where('stock', '<', 10)->count(),
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'todaySales' => $todaySales,
            'latestProducts' => Product::query()->latest()->take(5)->get(),
            'latestOrders' => Order::query()->with('user')->latest()->take(6)->get(),
        ]);
    }
}

