<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukReviewController extends Controller
{
    public function store(Request $request, Produk $produk)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        ProdukReview::updateOrCreate(
            [
                'produk_id' => $produk->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return back()->with('success', 'Rating berhasil disimpan');
    }
}
