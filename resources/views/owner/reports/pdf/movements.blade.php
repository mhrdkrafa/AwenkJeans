<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pergerakan Stok</title>
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
        .badge-in { background-color: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; }
        .badge-out { background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; }
        .text-green { color: #059669; }
        .text-amber { color: #d97706; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">AWENK JEANS - LAPORAN PERGERAKAN STOK</h1>
        <p class="subtitle">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px;"><strong>Total Barang Masuk (IN):</strong> <span class="text-green">+{{ number_format($totalIn, 0, ',', '.') }} unit</span></td>
                <td style="border: none; padding: 5px; text-align: right;"><strong>Total Barang Keluar (OUT):</strong> <span class="text-amber">-{{ number_format($totalOut, 0, ',', '.') }} unit</span></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Produk</th>
                <th width="10%" class="text-center">Tipe</th>
                <th width="10%" class="text-right">Jumlah</th>
                <th width="40%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $index => $movement)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ optional($movement->product)->name ?? '-' }}</td>
                <td class="text-center">
                    @if($movement->type === 'in')
                        <span class="badge-in">IN</span>
                    @else
                        <span class="badge-out">OUT</span>
                    @endif
                </td>
                <td class="text-right">
                    @if($movement->type === 'in')
                        <span class="text-green">+{{ $movement->quantity }}</span>
                    @else
                        <span class="text-amber">-{{ $movement->quantity }}</span>
                    @endif
                </td>
                <td>{{ $movement->description }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada pergerakan stok pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        @if($movements->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL MASUK (IN)</td>
                <td class="text-right text-green">+{{ number_format($totalIn, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KELUAR (OUT)</td>
                <td class="text-right text-amber">-{{ number_format($totalOut, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>
</body>
</html>
