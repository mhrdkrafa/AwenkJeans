<x-owner-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Dashboard Owner</h2>
            <p class="mt-1 text-sm text-slate-500">Ringkasan performa toko — hanya untuk dilihat.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Stats Cards --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Total Sales --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Total Penjualan</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                    <p class="mt-1 text-xs text-slate-400">Hari ini: Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Monthly Sales --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Penjualan Bulan Ini</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">Rp {{ number_format($monthlySales, 0, ',', '.') }}</h3>
                    <p class="mt-1 text-xs text-slate-400">{{ $paidTransactions }} transaksi lunas</p>
                </div>
            </div>

            {{-- Products & Transactions --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Total Produk</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">{{ $totalProducts }}</h3>
                    <p class="mt-1 text-xs text-slate-400">{{ $totalTransactions }} total transaksi</p>
                </div>
            </div>
        </div>

        {{-- Monthly Chart --}}
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Grafik Penjualan Bulanan</h3>
                    <p class="text-sm text-slate-500">Tren penjualan 12 bulan terakhir</p>
                </div>
                <a href="{{ route('owner.reports.sales') }}" class="rounded-xl bg-amber-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-amber-600">
                    Lihat Detail
                </a>
            </div>
            <div id="ownerMonthlySalesChart" class="min-h-[300px]"></div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Top Products --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Produk Terlaris</h3>
                    <p class="mt-1 text-sm text-slate-500">Berdasarkan jumlah unit terjual.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                                <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Terjual</th>
                                <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Omzet</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($topProducts as $item)
                                <tr class="group transition hover:bg-slate-50/50">
                                    <td class="py-4 pr-4 font-bold text-slate-900">
                                        {{ optional($item->product)->name ?: 'Produk tidak ditemukan' }}
                                    </td>
                                    <td class="py-4 pr-4 text-right">
                                        <span class="inline-flex items-center gap-1 font-bold text-slate-500">
                                            {{ number_format($item->total_qty, 0, ',', '.') }}
                                            <span class="text-[10px] font-medium text-slate-500">UNIT</span>
                                        </span>
                                    </td>
                                    <td class="py-4 text-right font-bold text-slate-900">
                                        Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center">
                                        <p class="text-sm text-slate-500 font-medium">Belum ada data penjualan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Transactions (view only) --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Transaksi Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">10 transaksi terakhir yang masuk.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Invoice</th>
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                                <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($recentTransactions as $transaction)
                                <tr class="group transition hover:bg-slate-50/50">
                                    <td class="py-3 pr-4">
                                        <p class="font-bold text-slate-900 text-xs">{{ $transaction->invoice_number }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span @class([
                                            'inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold',
                                            'bg-emerald-50 text-emerald-600 border border-emerald-100' => $transaction->payment_status === 'paid',
                                            'bg-amber-50 text-amber-600 border border-amber-100' => $transaction->payment_status === 'pending',
                                            'bg-rose-50 text-rose-600 border border-rose-100' => in_array($transaction->payment_status, ['failed', 'expired']),
                                        ])>
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right font-bold text-slate-900 text-xs">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center">
                                        <p class="text-sm text-slate-500 font-medium">Belum ada transaksi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Quick Links to Reports --}}
        <div class="rounded-[2rem] border border-amber-200 bg-amber-50/50 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900">Mode View-Only</p>
                    <p class="text-sm text-slate-600">Sebagai owner, Anda hanya dapat melihat laporan. Untuk mengelola data, hubungi karyawan atau administrator.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('owner.reports.sales') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-amber-700 shadow-sm border border-amber-200 transition hover:bg-amber-100">
                    📊 Laporan Penjualan
                </a>
                <a href="{{ route('owner.reports.stock') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-amber-700 shadow-sm border border-amber-200 transition hover:bg-amber-100">
                    📦 Laporan Stok
                </a>
                <a href="{{ route('owner.reports.movements') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-amber-700 shadow-sm border border-amber-200 transition hover:bg-amber-100">
                    🔄 Pergerakan Stok
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartOptions = {
                series: [{
                    name: 'Penjualan',
                    data: @json($monthlyChartData)
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    fontFamily: 'Figtree, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#f59e0b'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                stroke: { curve: 'smooth', width: 3 },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    padding: { left: 20, right: 20 }
                },
                xaxis: {
                    categories: @json($monthlyChartLabels),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#64748b', fontWeight: 600 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#64748b', fontWeight: 600 },
                        formatter: function (val) {
                            if (val >= 1000000) return (val / 1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return (val / 1000).toFixed(0) + 'rb';
                            return val;
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#ownerMonthlySalesChart"), chartOptions);
            chart.render();
        });
    </script>
    @endpush

</x-owner-layout>
