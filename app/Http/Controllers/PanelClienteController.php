<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class PanelClienteController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();
        $latestOrders = $user->orders()->with('items')->latest()->take(4)->get();
        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $profileFields = [
            $user->phone,
            $user->address,
            $user->city,
            $user->state,
            $user->postal_code,
        ];

        $completedFields = collect($profileFields)->filter(fn (?string $value) => filled($value))->count();
        $profileProgress = (int) round(($completedFields / count($profileFields)) * 100);

        return view('client.dashboard', [
            'cartCount' => $cartItems->sum('quantity'),
            'cartTotal' => $cartItems->sum(fn ($item) => ((float) $item->product->price) * $item->quantity),
            'pendingOrders' => $user->orders()->where('status', Order::STATUS_PENDING)->count(),
            'deliveredOrders' => $user->orders()->where('status', Order::STATUS_DELIVERED)->count(),
            'latestOrders' => $latestOrders,
            'featuredProducts' => $featuredProducts,
            'profileProgress' => $profileProgress,
        ]);
    }
}
