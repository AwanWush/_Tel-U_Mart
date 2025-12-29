<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Mengambil semua pesanan dengan relasi user dan details
        $pesanan = RiwayatPembelian::with(['user', 'details'])->latest()->get();
        return view('admin.orders.index', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = RiwayatPembelian::with('user', 'details')->findOrFail($id);

        // Menangkap 'status_antar' dari dropdown select
        $statusBaru = $request->status_antar;

        // --- PERBAIKAN LOGIKA OTOMATIS LUNAS ---
        // Menggunakan strtolower untuk menghindari kesalahan jika di DB tertulis 'TAKEAWAY' atau 'Takeaway'
if ($statusBaru === 'selesai') {
    $pesanan->status = 'Lunas';
}


        $pesanan->status_antar = $statusBaru;
        $pesanan->save();

        // Logika Pesan Email berdasarkan Status
        $pesanEmail = '';
        $judulEmail = '';

        switch ($statusBaru) {
            case 'dikonfirmasi':
                $judulEmail = 'Pesanan Sedang Diproses 📦';
                $pesanEmail = 'Kabar baik! Pesanan Anda #' . $pesanan->id_transaksi . ' saat ini sedang kami siapkan.';
                break;
            case 'siap_antar':
                $judulEmail = 'Pesanan Dalam Perjalanan 🛵';
                $pesanEmail = 'Pesanan Anda #' . $pesanan->id_transaksi . ' sudah selesai disiapkan dan sedang diantar oleh kurir kami.';
                break;
            case 'selesai':
                $judulEmail = 'Pesanan Telah Sampai ✅';
                $pesanEmail = 'Pesanan Anda #' . $pesanan->id_transaksi . ' telah dinyatakan selesai. Terima kasih sudah berbelanja di T-Mart!';
                break;
            default:
                $judulEmail = 'Pembaruan Status Pesanan';
                $pesanEmail = 'Ada perubahan status pada pesanan Anda #' . $pesanan->id_transaksi;
        }

        // Kirim Notifikasi & Email
        NotificationHelper::send(
            $pesanan->user,
            'order_update',
            $judulEmail,
            $pesanEmail,
            $pesanan
        );

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui ke ' . strtoupper(str_replace('_', ' ', $statusBaru)));
    }
}