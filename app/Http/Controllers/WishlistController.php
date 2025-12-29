<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ]);

        Wishlist::firstOrCreate([
            'user_id'    => Auth::id(),
            'produk_id' => $request->produk_id
        ]);

        return back()->with('success', 'Produk ditambahkan ke wishlist');
    }


    public function removeSelected(Request $request)
    {
        $request->validate([
            'wishlist_ids' => 'required|array'
        ]);

        Wishlist::whereIn('id', $request->wishlist_ids)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success','Produk berhasil dihapus dari wishlist');
    }

    public function moveToCart(Request $request)
    {
        $request->validate([
            'wishlist_ids' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {

            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);

            $wishlists = Wishlist::with('produk')
                ->whereIn('id', $request->wishlist_ids)
                ->where('user_id', Auth::id())
                ->get();

            foreach ($wishlists as $wish) {
                if ($wish->produk->stok < 1) continue;

                $item = CartItem::firstOrNew([
                    'cart_id'    => $cart->id,
                    'product_id' => $wish->produk->id
                ]);

                $item->quantity = ($item->quantity ?? 0) + 1;
                $item->price    = $wish->produk->harga;
                $item->save();

                $wish->delete();
            }
        });

        return back()->with('success','Produk dipindahkan ke keranjang');
    }

    public function destroy($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success','Produk dihapus dari wishlist');
    } 
}
 