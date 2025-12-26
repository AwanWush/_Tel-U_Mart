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
    // Mengambil semua data keranjang milik user yang sedang login
    $cartItems = Cart::where('user_id', auth()->id())
        ->with('produk') // Load data produk agar tidak query berulang (Eager Loading)
        ->get();

    return view('cart.index', compact('cartItems'));
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
            'produk_id' => 'required|exists:produk,id', // Pastikan namanya produk_id sesuai database
            'qty' => 'nullable|integer|min:1',
        ]);

        $qty = $request->qty ?? 1;
        $userId = Auth::id();
        $produkId = $request->produk_id;

        // Cari apakah produk ini sudah ada di keranjang user tersebut
        $cartItem = Cart::where('user_id', $userId)
            ->where('produk_id', $produkId)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan jumlahnya
            $cartItem->increment('quantity', $qty);
        } else {
            // Jika belum ada, buat baris baru
            Cart::create([
                'user_id' => $userId,
                'produk_id' => $produkId,
                'quantity' => $qty,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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
