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
        $cart = Cart::with('items.produk')
            ->where('user_id', Auth::id())
            ->first();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
        ]);

        $produk = Produk::findOrFail($request->product_id);

        if ($produk->stok < 1) {
            return back()->with('error', 'Stok produk habis');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $produk->id,
        ]);

        $item->quantity = ($item->quantity ?? 0) + 1;
        $item->price = $produk->harga;
        $item->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $qty = $request->qty ?? 1;

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $item = $cart->items()
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('quantity', $qty);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $qty,
                'price' => Produk::find($request->product_id)->harga,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
