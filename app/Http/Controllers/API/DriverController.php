<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        // Menampilkan pesanan yang statusnya 'diproses' (siap antar)
        // Berdasarkan SQL kamu, kita pakai kolom 'status_antar'
        $pesanan = RiwayatPembelian::with('user')
            ->where('status_antar', 'diproses')
            ->orWhere('status_antar', 'sedang diantar')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = RiwayatPembelian::findOrFail($id);
        
        // Update status antar menjadi selesai
        $pesanan->update([
            'status_antar' => 'selesai'
        ]);

        return response()->json(['message' => 'Pesanan berhasil diselesaikan!']);
    }
}