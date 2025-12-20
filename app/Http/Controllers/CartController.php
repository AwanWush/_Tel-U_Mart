<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (! $cart) {
            return view('cart.index', ['items' => collect()]);
        }

        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('produk')
            ->get();

        return view('cart.index', [
            'items' => $cartItems,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
        ]);

        $produk = Produk::findOrFail($request->product_id);

        if ($produk->stok < 1 || $produk->status_ketersediaan !== 'Tersedia') {
            return back()->with('error', 'Stok produk habis');
        }

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id, 
            ]);
        }

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $produk->id,
        ]);

        if ($item->exists && $item->quantity >= $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $item->quantity = ($item->quantity ?? 0) + 1;
        $item->price = $produk->harga;
        $item->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $item->produk->stok) {
            return back()->with('error', 'Jumlah melebihi stok');
        }

        $item->quantity = $request->quantity;
        $item->save();

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();

        return redirect()->route('cart.index');
    }
}
