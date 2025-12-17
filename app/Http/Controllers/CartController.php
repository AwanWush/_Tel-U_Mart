<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $items = $cart->items()->with('produk')->get();

        return view('cart.index', compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id'
        ]);

        $produk = Produk::findOrFail($request->product_id);

        if ($produk->stok < 1 || $produk->status_ketersediaan !== 'Tersedia') {
            return back()->with('error', 'Stok produk habis');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $produk->id
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
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity > $item->produk->stok) {
            return back()->with('error', 'Jumlah melebihi stok');
        }

        $item->update([
            'quantity' => $request->quantity
        ]);

        return back();
    }

    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();
        return back();
    }
}

