<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #003B95; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #003B95; margin: 0; }
        .subtitle { font-size: 12px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; color: #334155; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #f1f5f9; }
        .summary { margin-top: 30px; border: 1px solid #ddd; padding: 15px; background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">AWENK JEANS - LAPORAN PENJUALAN</h1>
        <p class="subtitle">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px;"><strong>Total Transaksi:</strong> {{ $transactions->count() }} Struk</td>
                <td style="border: none; padding: 5px; text-align: right;"><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Invoice</th>
                <th width="20%">Pelanggan</th>
                <th width="20%">Kasir</th>
                <th width="20%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->invoice_number }}</td>
                <td>{{ $trx->customer_name ?: '-' }}</td>
                <td>{{ optional($trx->user)->name ?? 'System' }}</td>
                <td class="text-right">{{ number_format($trx->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>
</body>
</html>
