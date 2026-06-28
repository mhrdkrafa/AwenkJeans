<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota #{{ $transaction->invoice_number }}</title>
    <style>
        @page { margin: 25mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 13px; color: #1e293b; line-height: 1.5; }
        
        .receipt { width: 100%; padding: 0; }
        
        /* Header */
        .header { text-align: center; border-bottom: 3px solid #003B95; padding-bottom: 18px; margin-bottom: 20px; }
        .header h1 { font-size: 28px; color: #003B95; letter-spacing: 3px; margin-bottom: 5px; }
        .header p { font-size: 12px; color: #64748b; }
        
        /* Invoice Info */
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .info-table .label { color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 140px; }
        .info-table .value { font-weight: 600; color: #1e293b; font-size: 13px; }
        
        /* Items Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table thead th {
            background-color: #003B95;
            color: #ffffff;
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table thead th.text-right { text-align: right; }
        .items-table thead th.text-center { text-align: center; }
        .items-table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }
        .items-table tbody td.text-right { text-align: right; }
        .items-table tbody td.text-center { text-align: center; }
        .items-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        
        /* Total Section */
        .total-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .total-table td { padding: 6px 12px; }
        .total-table .total-label { text-align: right; color: #64748b; font-size: 13px; }
        .total-table .total-value { text-align: right; font-size: 13px; font-weight: 600; width: 180px; }
        .total-table .grand-total .total-label { font-size: 15px; color: #1e293b; font-weight: 700; }
        .total-table .grand-total .total-value { font-size: 20px; color: #003B95; font-weight: 700; }
        .total-table .grand-total td { padding-top: 10px; border-top: 2px solid #e2e8f0; }
        
        /* Status Badge */
        .badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-paid { background-color: #d1fae5; color: #065f46; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        
        /* Footer */
        .footer { text-align: center; border-top: 2px dashed #cbd5e1; padding-top: 18px; margin-top: 20px; }
        .footer p { font-size: 11px; color: #94a3b8; margin-bottom: 4px; }
        .footer .thank-you { font-size: 14px; font-weight: 700; color: #003B95; margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>AWENK JEANS</h1>
            <p>Jl. Contoh Alamat No. 123, Kota</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <!-- Invoice Info -->
        <table class="info-table">
            <tr>
                <td class="label">No. Invoice</td>
                <td class="value">{{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="value">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Pelanggan</td>
                <td class="value">{{ $transaction->customer_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">No. Telepon</td>
                <td class="value">{{ $transaction->customer_phone ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kasir</td>
                <td class="value">{{ $transaction->cashier->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Metode Bayar</td>
                <td class="value">{{ strtoupper($transaction->payment_method) }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="value">
                    <span class="badge {{ $transaction->payment_status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                        {{ $transaction->payment_status === 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                    </span>
                </td>
            </tr>
        </table>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Produk</th>
                    <th style="width: 20%;">Kategori/Ukuran</th>
                    <th class="text-right" style="width: 18%;">Harga</th>
                    <th class="text-center" style="width: 8%;">Qty</th>
                    <th class="text-right" style="width: 19%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td><strong>{{ $detail->product->name ?? 'Produk dihapus' }}</strong></td>
                    <td>{{ $detail->product->category->name ?? '-' }} / {{ $detail->product->size->name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <table class="total-table">
            <tr>
                <td class="total-label">Total Item</td>
                <td class="total-value">{{ $transaction->details->sum('quantity') }} pcs</td>
            </tr>
            <tr class="grand-total">
                <td class="total-label">TOTAL BAYAR</td>
                <td class="total-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p class="thank-you">Terima Kasih Atas Pembelian Anda!</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan</p>
            <p>kecuali melalui fitur komplain di website kami.</p>
            <p style="margin-top: 10px;">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i:s') }} WIB</p>
        </div>
    </div>
</body>
</html>
