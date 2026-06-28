<!-- @extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Dashboard Admin</h2>

    {{-- KPI --}}
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3">
                <h6>Total Penjualan</h6>
                <h4 class="text-success">Rp {{ number_format($totalSales) }}</h4>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3">
                <h6>Hari Ini</h6>
                <h4 class="text-primary">Rp {{ number_format($todaySales) }}</h4>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3">
                <h6>Total Transaksi</h6>
                <h4>{{ $totalTransactions }}</h4>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3">
                <h6>Stok Menipis</h6>
                <h4 class="text-danger">{{ $lowStockCount }}</h4>
            </div>
        </div>

    </div>

    {{-- GRAFIK --}}
    <div class="card p-4 shadow mt-4">
        <h5>Grafik Penjualan</h5>
        <canvas id="salesChart"></canvas>
    </div>

    {{-- PRODUK TERLARIS --}}
    <div class="card p-4 shadow mt-4">
        <h5>Produk Terlaris</h5>
        <ul>
            @foreach($topProducts as $item)
                <li>
                    {{ $item->product->name ?? '-' }} 
                    ({{ $item->total_qty }} terjual)
                </li>
            @endforeach
        </ul>
    </div>

    {{-- TRANSAKSI --}}
    <div class="card p-4 shadow mt-4">
        <h5>Transaksi Terbaru</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTransactions as $trx)
                <tr>
                    <td>#{{ $trx->id }}</td>
                    <td>Rp {{ number_format($trx->total_price) }}</td>
                    <td>{{ $trx->payment_status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Penjualan',
            data: @json($data),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});
</script>

@endsection -->