<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CarritoController extends Controller
{
    public function index(Request $request): View
    {
        $items = $request->user()
            ->cartItems()
            ->with('product')
            ->latest()
            ->get();

        $total = $items->sum(fn (CartItem $item) => ((float) $item->product->price) * $item->quantity);

        return view('client.cart', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active) {
            return back()->with('status', 'El producto no esta disponible actualmente.');
        }

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
        $quantity = $validated['quantity'] ?? 1;

        $item = $request->user()->cartItems()->firstOrNew([
            'product_id' => $product->id,
        ]);
        $item->quantity = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->save();

        return redirect()->route('client.cart')->with('status', 'Producto agregado al carrito.');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        abort_unless($item->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $item->update([
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->route('client.cart')->with('status', 'Cantidad actualizada.');
    }

    public function destroy(Request $request, CartItem $item): RedirectResponse
    {
        abort_unless($item->user_id === $request->user()->id, 403);
        $item->delete();

        return redirect()->route('client.cart')->with('status', 'Producto eliminado del carrito.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();
        $items = $user->cartItems()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('client.cart')->with('status', 'No hay productos en el carrito.');
        }

        if (! $user->address) {
            return redirect()->route('profile.edit')
                ->with('status', 'Completa tu direccion en el perfil antes de comprar.');
        }

        DB::transaction(function () use ($user, $items): void {
            $total = $items->sum(fn (CartItem $item) => ((float) $item->product->price) * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'status' => Order::STATUS_PENDING,
                'shipping_name' => $user->name,
                'shipping_phone' => $user->phone,
                'shipping_address' => $user->address,
                'shipping_city' => $user->city,
                'shipping_state' => $user->state,
                'shipping_postal_code' => $user->postal_code,
                'total' => $total,
            ]);

            foreach ($items as $item) {
                $unitPrice = (float) $item->product->price;
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'subtotal' => $unitPrice * $item->quantity,
                ]);
            }

            $user->cartItems()->delete();
        });

        return redirect()->route('client.orders.index')->with('status', 'Pago realizado. Tu pedido quedo pendiente.');
    }
}

