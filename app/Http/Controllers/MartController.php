<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MartController extends Controller
{
    public function select(Request $request)
    {
        $request->validate([
            'mart_id' => 'nullable|exists:mart,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $user->update([
            'active_mart_id' => $request->mart_id ?: null,
        ]);

        return back()->with('success', 'Prioritas toko berhasil diperbarui');
    }
}
