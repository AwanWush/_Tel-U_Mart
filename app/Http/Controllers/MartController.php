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
            'mart_id' => 'required|exists:mart,id',
        ]);

        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $user->update([
            'active_mart_id' => $request->mart_id,
        ]);

        return back()->with('success', 'Prioritas toko berhasil diperbarui');
    }
}
