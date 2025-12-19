<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function selected(Request $request)
    {
        $request->validate([
            'cart_items' => 'required|array|min:1',
        ]);

        $items = CartItem::with('produk')
            ->whereIn('id', $request->cart_items)
            ->get();

        $total = $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return view('checkout.index', compact('items', 'total'));
    }
}
