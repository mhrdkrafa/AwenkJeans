<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Dashboard Karyawan</h2>
            <p class="mt-1 text-sm text-slate-500">Ringkasan penjualan, stok, dan aktivitas toko terbaru.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Stats Cards --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Total Sales --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-[#1D4ED8]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-xs font-bold text-emerald-600">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        12.5%
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Total Penjualan</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- Transactions --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 118 0m-4 15a8 8 0 11-16 0 8 8 0 0116 0zM5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-1 text-xs font-bold text-emerald-600">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        8.2%
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Total Transaksi</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">{{ $totalTransactions }}</h3>
                </div>
            </div>

            {{-- Products --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-[#1D4ED8]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 rounded-full bg-rose-100 px-2 py-1 text-xs font-bold text-rose-600">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        3.1%
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Total Produk</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">{{ $totalProducts }}</h3>
                </div>
            </div>

            {{-- Low Stock --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">Stok Menipis</p>
                    <h3 class="mt-1 text-2xl font-bold text-rose-600">{{ $lowStockCount }}</h3>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Monthly Sales Chart --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Monthly Sales</h3>
                        <p class="text-sm text-slate-500">Penjualan bulanan tahun ini</p>
                    </div>
                    <div class="relative">
                        <button class="text-slate-500 hover:text-slate-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="monthlySalesChart" class="min-h-[300px]"></div>
            </div>

            {{-- Category Sales Stacked Chart --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Category Performance</h3>
                        <p class="text-sm text-slate-500">Performa penjualan per kategori</p>
                    </div>
                </div>
                <div id="categoryChart" class="min-h-[300px]"></div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Penjualan 7 hari terakhir</h3>
                        <p class="mt-1 text-sm text-slate-500">Pantau ritme omzet mingguan untuk melihat performa toko.</p>
                    </div>
                    <a href="{{ route('karyawan.transactions.index') }}" class="rounded-xl bg-[#1D4ED8] px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-[#002d73]">
                        Lihat Transaksi
                    </a>
                </div>

                @php
                    $maxWeeklySales = max($weeklySales->max('total'), 1);
                @endphp

                <div class="mt-6 space-y-4">
                    @foreach ($weeklySales as $sale)
                        @php
                            $width = ($sale['total'] / $maxWeeklySales) * 100;
                        @endphp
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-500">{{ $sale['full_label'] }}</span>
                                <span class="font-semibold text-slate-900">Rp {{ number_format($sale['total'], 0, ',', '.') }}</span>
                            </div>
                            <div class="h-3 overflow-hidden rounded-full bg-slate-50">
                                <div class="h-full rounded-full bg-[#1D4ED8]" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Stok prioritas</h3>
                        <p class="mt-1 text-sm text-slate-500">Produk yang sudah menyentuh batas minimal stok.</p>
                    </div>
                    <a href="{{ route('karyawan.products.index') }}" class="text-sm font-medium text-[#1D4ED8] hover:text-[#002d73]">
                        Kelola produk
                    </a>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($lowStockProducts as $product)
                        <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 transition hover:bg-rose-100/50">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $product->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">Batas minimum {{ $product->min_stock }} unit</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-sm font-bold text-rose-600 shadow-sm">
                                    {{ $product->stock }} stok
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-6 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-emerald-600 shadow-sm">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="mt-4 text-sm font-medium text-emerald-700">Semua stok aman!</p>
                            <p class="mt-1 text-xs text-emerald-600/80">Tidak ada produk di bawah batas minimum.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Transaksi terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">Monitor transaksi terakhir yang masuk ke sistem.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Invoice</th>
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Pelanggan</th>
                                <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                                <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($recentTransactions as $transaction)
                                <tr class="group transition hover:bg-slate-50/50">
                                    <td class="py-4 pr-4">
                                        <p class="font-bold text-slate-900 group-hover:text-[#1D4ED8] transition">{{ $transaction->invoice_number }}</p>
                                        <p class="text-xs text-slate-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="py-4 pr-4">
                                        <p class="font-medium text-slate-600">{{ $transaction->customer_name ?: 'Walk-in Customer' }}</p>
                                        <p class="text-xs text-slate-500">{{ optional($transaction->user)->name ?: 'Sistem' }}</p>
                                    </td>
                                    <td class="py-4 pr-4">
                                        <span @class([
                                            'inline-flex rounded-full px-3 py-1 text-xs font-bold',
                                            'bg-emerald-50 text-emerald-600 border border-emerald-100' => $transaction->payment_status === 'paid',
                                            'bg-amber-50 text-amber-600 border border-amber-100' => $transaction->payment_status === 'pending',
                                            'bg-rose-50 text-rose-600 border border-rose-100' => in_array($transaction->payment_status, ['failed', 'expired']),
                                        ])>
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right font-bold text-slate-900">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <p class="text-sm text-slate-500 font-medium">Belum ada transaksi yang tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Produk terlaris</h3>
                    <p class="mt-1 text-sm text-slate-500">Produk dengan penjualan tertinggi berdasarkan quantity.</p>
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
                                    <td class="py-4 pr-4 font-bold text-slate-900 group-hover:text-[#1D4ED8] transition">
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
                                        <p class="text-sm text-slate-500 font-medium">Data produk terlaris belum tersedia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900">Aktivitas stok terbaru</h3>
                <p class="mt-1 text-sm text-slate-500">Pergerakan stok terakhir dari transaksi atau penyesuaian barang.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($recentStockMovements as $movement)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-4 transition hover:bg-white hover:shadow-md">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-bold text-slate-900 truncate">{{ optional($movement->product)->name ?: 'Produk tidak ditemukan' }}</p>
                            <span @class([
                                'rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider',
                                'bg-emerald-50 text-emerald-600 border border-emerald-100' => $movement->type === 'in',
                                'bg-amber-50 text-amber-600 border border-amber-100' => $movement->type === 'out',
                            ])>
                                {{ $movement->type }}
                            </span>
                        </div>
                        <div class="mt-4 flex items-baseline gap-1">
                            <span class="text-2xl font-black {{ $movement->type === 'in' ? 'text-emerald-600' : 'text-amber-600' }}">{{ number_format($movement->quantity, 0, ',', '.') }}</span>
                            <span class="text-xs font-bold text-slate-500">UNIT</span>
                        </div>
                        <p class="mt-2 text-xs font-medium text-slate-500 leading-relaxed line-clamp-2">{{ $movement->description ?: 'Perubahan stok manual.' }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $movement->created_at->format('d M Y H:i') }}
                            </div>
                            <div class="flex items-center gap-1 text-[10px] font-semibold text-slate-400">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ optional($movement->user)->name ?? 'Sistem' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-12 text-center">
                        <p class="text-sm font-medium text-slate-500">Belum ada aktivitas stok yang tercatat.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration shared by both charts
            const commonOptions = {
                chart: {
                    fontFamily: 'Figtree, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                states: {
                    hover: { filter: { type: 'darken', value: 0.95 } }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    padding: { left: 20, right: 20, top: 0, bottom: 0 }
                },
                dataLabels: { enabled: false },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    }
                }
            };

            // Monthly Sales Chart
            const monthlyOptions = {
                ...commonOptions,
                series: [{
                    name: 'Sales',
                    data: @json($monthlyChartData)
                }],
                chart: {
                    ...commonOptions.chart,
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 12,
                        columnWidth: '45%',
                        distributed: false
                    }
                },
                colors: ['#4f46e5'],
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
                }
            };

            const monthlyChart = new ApexCharts(document.querySelector("#monthlySalesChart"), monthlyOptions);
            monthlyChart.render();

            // Category Chart (Stacked)
            const categoryOptions = {
                ...commonOptions,
                series: @json($categoryChartData),
                chart: {
                    ...commonOptions.chart,
                    type: 'bar',
                    height: 350,
                    stacked: true
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '45%',
                    }
                },
                colors: ['#4f46e5', '#818cf8', '#a5b4fc', '#c7d2fe'],
                xaxis: {
                    categories: @json($categoryLabels),
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
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    fontFamily: 'Figtree',
                    fontWeight: 600,
                    fontSize: '13px',
                    markers: { radius: 12 }
                }
            };

            const categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
            categoryChart.render();
        });
    </script>
    @endpush

</x-admin-layout>
