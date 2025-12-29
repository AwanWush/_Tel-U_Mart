<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    public function store(Request $request)
    {   dd($request->all());
        

        $request->validate([
            'kategori'   => 'required|string',
            'keterangan' => 'nullable|string|max:255',
            'telepon'    => 'nullable|string|max:20',
            'bank'       => 'nullable|string|max:50',
            'norek'      => 'nullable|string|max:50',
        ]);

        MetodePembayaran::create([
            'user_id'    => auth()->id(),
            'kategori'   => $request->kategori,
            'keterangan' => $request->keterangan,
            'telepon'    => $request->telepon,
            'bank'       => $request->bank,
            'norek'      => $request->norek,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Metode pembayaran berhasil ditambahkan');
    }
}
