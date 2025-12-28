<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: #4f46e5; color: #ffffff; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .status-box { background: #f3f4f6; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0; border: 1px solid #d1d5db; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { text-align: left; color: #6b7280; font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; }
        .table td { padding: 12px 0; border-bottom: 1px solid #f3f4f6; font-size: 14px; }
        .total-row { font-weight: bold; font-size: 18px; color: #ef4444; }
        .footer { background: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">T-Mart Point</h1>
            <p style="margin:5px 0 0; opacity: 0.8;">Update Transaksi Anda</p>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $order->user->name }}</strong>!</p>
            <p>Pembaruan status untuk pesanan nomor invoice <strong>#{{ $order->id_transaksi }}</strong>.</p>

            <div class="status-box">
                <span style="font-size: 11px; color: #6b7280; display: block; margin-bottom: 5px; letter-spacing: 1px;">STATUS PENGANTARAN:</span>
                <strong style="font-size: 20px; color: #4f46e5;">{{ strtoupper($order->status_antar ?? 'DIPROSES') }}</strong>
            </div>

            <h3 style="border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">Rincian Pesanan:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Harga Satuan</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                    <tr>
                        <td>{{ $detail->nama_produk }}</td>
                        <td style="text-align: center;">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $detail->jumlah }}</td>
                        <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="padding-top: 20px;"><strong>TOTAL PEMBAYARAN</strong></td>
                        <td style="text-align: right; padding-top: 20px;" class="total-row">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <p style="margin-top: 30px; font-size: 13px; color: #6b7280; font-style: italic;">
                * Terima kasih telah mempercayai T-Mart untuk kebutuhan asrama Anda.
            </p>
        </div>

        <div class="footer">
            &copy; 2025 TJ-T Mart Smart Energy System <br>
            Telkom University, Bandung, Indonesia
        </div>
    </div>
</body>
</html>