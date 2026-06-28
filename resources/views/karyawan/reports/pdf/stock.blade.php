<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Sisa Stok</title>
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
        .text-danger { color: #dc2626; font-weight: bold; }
        .text-warning { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">AWENK JEANS - LAPORAN SISA STOK</h1>
        <p class="subtitle">Kondisi per tanggal: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="summary">
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px;"><strong>Total Item Fisik:</strong> {{ number_format($totalStock, 0, ',', '.') }} Unit</td>
                <td style="border: none; padding: 5px; text-align: right;"><strong>Estimasi Nilai Aset:</strong> Rp {{ number_format($totalValue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Produk</th>
                <th width="20%">Kategori / Size</th>
                <th width="15%" class="text-right">Harga (Rp)</th>
                <th width="10%" class="text-center">Sisa Stok</th>
                <th width="20%" class="text-right">Total Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ optional($product->category)->name }} / {{ optional($product->size)->name ?? '-' }}</td>
                <td class="text-right">{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-center @if($product->stock == 0) text-danger @elseif($product->stock <= $product->min_stock) text-warning @endif">
                    {{ $product->stock }}
                </td>
                <td class="text-right">{{ number_format($product->price * $product->stock, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data produk.</td>
            </tr>
            @endforelse
        </tbody>
        @if($products->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-center">{{ number_format($totalStock, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalValue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
