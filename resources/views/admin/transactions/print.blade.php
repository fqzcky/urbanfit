<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #000; background: #fff; padding: 20px; font-size: 14px; }
        .invoice-box { max-width: 600px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px dashed #000; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: 2px; }
        table { width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .total-row td { border-top: 2px solid #000; font-size: 16px; font-weight: bold; }
    </style>
</head>
<body onload="window.print()"> <div class="invoice-box">
        <div class="header">
            <h1>URBAN SNEAKERS.</h1>
            <p>Bukti Pembayaran / Invoice</p>
        </div>
        
        <table style="border: none; margin-bottom: 30px;">
            <tr style="border: none;">
                <td style="border: none; padding: 0;">
                    <p><strong>ID Transaksi:</strong> #TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}<br>
                    <strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Status:</strong> {{ $transaction->status }}</p>
                </td>
                <td style="border: none; padding: 0;" class="text-right">
                    <p><strong>Kepada:</strong><br>
                    {{ $transaction->name }}<br>
                    {{ $transaction->phone }}<br>
                    {{ $transaction->address }}</p>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Size</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product ? $detail->product->name : 'Produk Dihapus' }}</td>
                    <td class="text-center">{{ $detail->size }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL :</td>
                    <td class="text-right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        
        <div class="text-center" style="margin-top: 40px;">
            <p>Terima kasih telah berbelanja di Urban Sneakers!</p>
            <p><em>-- Harap simpan struk ini sebagai bukti pembayaran --</em></p>
        </div>
    </div>

</body>
</html>