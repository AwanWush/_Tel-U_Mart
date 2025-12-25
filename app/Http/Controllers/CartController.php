<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('produk')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'qty' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('produk_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->qty);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->product_id,
                'quantity' => $request->qty,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambah!');
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